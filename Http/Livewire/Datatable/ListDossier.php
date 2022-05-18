<?php

namespace Modules\CrmAutoCar\Http\Livewire\Datatable;

use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\CoreCRM\Models\Commercial;
use Modules\CoreCRM\Models\Status;
use Modules\CrmAutoCar\Actions\ExportDossier;
use Modules\CrmAutoCar\Http\Livewire\ListFormulaire;
use Modules\CrmAutoCar\Models\Dossier;
use Modules\CrmAutoCar\Models\Tag;
use Modules\CrmAutoCar\Repositories\DossierAutoCarRepository;
use Modules\CrmAutoCar\Tables\Columns\BureauColumn;
use Modules\CrmAutoCar\Tables\Columns\DateVoyageColumn;
use Modules\CrmAutoCar\Tables\Columns\TagsTable;
use pxlrbt\FilamentExcel\Actions\ExportAction;
use Spatie\Permission\Models\Role;

class ListDossier extends Component implements Tables\Contracts\HasTable
{

    use Tables\Concerns\InteractsWithTable;


    protected $queryString = [
        'tableFilters',
        'tableSortColumn',
        'tableSortDirection',
        'tableSearchQuery' => ['except' => ''],
    ];

    protected $repository = null;

    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->repository =  app(DossierAutoCarRepository::class);
    }

    protected function getTableQuery(): Builder
    {
        $query = $this->repository->newQuery();

        if(
            !\Auth::user()->isSuperAdmin() &&
            !\Auth::user()->can('changeCommercial', \Modules\CrmAutoCar\Models\Proformat::class)
        ) {
            $query->where(function($query) {
                $query->where('commercial_id', \Auth::user()->id)
                    ->orWhereHas('followers', function ($query) {
                        $query->where('user_id', \Auth::user()->id);
                    });
            });
        }

        return $query;
    }


    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\ImageColumn::make('client.avatar_url')
                ->label('')
                ->rounded(true),
            BureauColumn::make('commercial.roles')
                ->label('Bureau')
                ->toggleable(\Auth::user()->isSuperAdmin(),isToggledHiddenByDefault: true),

            Tables\Columns\TextColumn::make('ref')
                ->label('Ref')
                ->sortable(['dossiers.id'])
                ->searchable()
                ->toggleable(true),

            Tables\Columns\TextColumn::make('client.format_name')
                ->label('Client')
                ->sortable()
                ->searchable()
                ->toggleable(true),

            Tables\Columns\TextColumn::make('client.company')
                ->label('Société')
                ->default('N/A')
                ->sortable()
                ->searchable()
                ->toggleable(true),
            Tables\Columns\TextColumn::make('status.label')
                ->label('Statut')
                ->extraAttributes(function (...$params) {
                    return [
                        'style' => 'background-color:' . $params[2]->status->color,
                        'class' => 'text-white rounded'
                    ];
                })
                ->sortable()
                ->toggleable(true),

            TagsTable::make('tags')
                ->label('Tags')
                ->toggleable(true),

            Tables\Columns\TextColumn::make('date_depart')
                ->label('Date de départ')
                ->sortable()
                ->searchable()
                ->toggleable(true),
            Tables\Columns\TextColumn::make('lieu_depart')
                ->label('Lieu de départ')
                ->sortable(['data->lieu_depart'])
                ->searchable()
                ->toggleable(true),

            DateVoyageColumn::make('devis')
                ->label('Date du voyage')
                ->sortable()
                ->toggleable(true),

            Tables\Columns\ImageColumn::make('commercial.avatar_url')
                ->label('Commercial')
                ->tooltip(fn(Model $record): string => "{$record->commercial->format_name}")
                ->rounded()
                ->sortable()
                ->searchable()
                ->alignCenter()
                ->extraAttributes([
                    'class' => 'flex justify-center items-center'
                ])
                ->toggleable(true),

            Tables\Columns\TextColumn::make('signature_at')
                ->label('Signer le')
                ->dateTime()
                ->sortable()
                ->toggleable(true),

        ];
    }

    protected function applySortingToTableQuery(Builder $query): Builder
    {
        if (filled($sortCol = $this->getTableSortColumn()) && filled($sortDir = $this->getTableSortDirection())) {

            $ordersBy = [
                'date_depart' => function($query, $direction) {
                    return $query->orderByRaw("STR_TO_DATE(json_unquote(json_extract(data, '$.date_depart')), '%d/%c/%Y') $direction");
                },
                'date_arrive' => function($query, $direction) {
                    return $query->orderByRaw("STR_TO_DATE(json_unquote(json_extract(data, '$.date_arrive')), '%d/%c/%Y') $direction");
                },
                'created_at' => function ($query, $direction) {
                    $query->orderBy('created_at', $direction);
                },
                'signature_at' => function ($query, $direction) {
                    $query->orderBy(function ($query) {
                        $query
                            ->select('proformats.created_at')
                            ->from('devis')
                            ->join('proformats', 'devis.id', '=', 'proformats.devis_id')
                            ->whereColumn('devis.dossier_id', 'dossiers.id')
                            ->orderBy('proformats.created_at', 'asc')
                            ->limit(1);
                    }, $direction);
                },
                'updated_at' => function ($query, $direction) {
                    $query->orderBy(function ($query) {
                        $query->from('devis')
                            ->select('updated_at')
                            ->whereColumn(
                                'devis.dossier_id',
                                'dossiers.id'
                            )
                            ->limit(1);
                    }, $direction);
                },
                'id' => function ($query, $direction) {
                    $query->orderBy('id', $direction);
                },
                'client.format_name' => function ($query, $direction) {
                    $query->orderBy(function ($query) {
                        $query
                            ->select(DB::raw('CONCAT(personnes.firstname,personnes.lastname) as format_name'))
                            ->from('clients')
                            ->leftJoin('personnes', 'personnes.id', '=', 'clients.personne_id')
                            ->whereColumn('clients.id', 'dossiers.clients_id')
                            ->limit(1);
                    }, $direction);
                },
                'company' => function ($query, $direction) {
                    $query->orderBy(function ($query) {
                        $query
                            ->select('company')
                            ->from('clients')
                            ->whereColumn('clients.id', 'dossiers.clients_id')
                            ->limit(1);
                    }, $direction);
                },
                'status.label' => function ($query, $direction) {
                    $query->orderBy(function ($query) {
                        $query
                            ->select('statuses.order')
                            ->from('statuses')
                            ->whereColumn('statuses.id', 'dossiers.status_id');
                    }, $direction);
                },
                'devis' => function ($query, $direction) {
                    $query->orderBy(function ($query) {
                        $query->from('devis')
                            ->selectRaw("json_unquote(json_extract(`data`, '$.trajets[0].aller_date_depart'))")
                            ->whereColumn(
                                'devis.dossier_id',
                                'dossiers.id'
                            )
                            ->limit(1);
                    }, $direction);
                },
                'commercial.avatar_url' => function ($query, $direction) {
                    $query->orderBy(function ($query) {
                        $query
                            ->select(DB::raw('CONCAT(personnes.firstname,personnes.lastname) as format_name'))
                            ->from('users')
                            ->leftJoin('personnes', 'personnes.id', '=', 'users.personne_id')
                            ->whereColumn('users.id', 'dossiers.commercial_id')
                            ->limit(1);
                    }, $direction);
                },
                'gestionnaire' => function ($query, $direction) {
                    $query->orderBy(function ($query) {
                        $query
                            ->select(DB::raw('CONCAT(personnes.firstname,personnes.lastname) as format_name'))
                            ->from('users')
                            ->leftJoin('personnes', 'personnes.id', '=', 'users.personne_id')
                            ->leftJoin('dossier_user', 'dossier_user.user_id', '=', 'users.id')
                            ->whereColumn('dossier_user.dossier_id', 'dossiers.id')
                            ->limit(1);
                    }, $direction);
                },
            ];

            if (($ordersBy[$sortCol] ?? false) && is_callable($ordersBy[$sortCol])) {
                $direction = $sortDir;
                $ordersBy[$sortCol]($query, $direction);
            } else {
                $columnName = $this->tableSortColumn;

                if (!$columnName) {
                    return $query;
                }

                $direction = $this->tableSortDirection ?? 'asc';

                $column = $this->getCachedTableColumn($columnName);

                if (!$column) {
                    return $query->orderBy($columnName, $direction);
                }

                $column->applySort($query, $direction);

                return $query;
            }

        }

        return $query;
    }

    protected function applySearchToTableQuery(Builder $query): Builder
    {
        if (filled($searchQuery = $this->getTableSearchQuery())) {
            $query->where(function (Builder $query) use ($searchQuery) {
                $query->setQuery(
                    $this->repository->searchQuery($query, $searchQuery)
                        ->getQuery()
                );
            });
        }

        return $query;
    }

    protected function getTableRecordUrlUsing(): \Closure
    {
        return fn(Model $record): string => route('dossiers.show', ['client' => $record->client, 'dossier' => $record]);
    }

    protected function getTableFiltersFormColumns(): int
    {
        return 4;
    }

    protected function getDefaultStatusProperty(){
        return ['4'];
    }

    protected function getTableFilters(): array
    {
        $filters = [

            Tables\Filters\MultiSelectFilter::make('status')
                ->options(fn() => Status::all()->pluck('label', 'id'))
                ->column('status_id')
                ->default($this->getDefaultStatusProperty()),
            Tables\Filters\MultiSelectFilter::make('tag')
                ->options(fn() => Tag::all()->pluck('label', 'id'))
                ->query(function ($query, $data) {
                    if (count($data['values']) > 0) {
                        return $query->whereHas('tags', function (Builder $query) use ($data) {
                            $query->whereIn('tag_id', $data['values']);
                        });
                    }
                }),
            Tables\Filters\Filter::make('depart')
                ->form([
                    DatePicker::make('depart')->label('Départ'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['depart'],
                            function(Builder $query, $date){
                                $dateStart = Carbon::parse($date)->startOfDay();
                                $collection = $query->with('devis')->get();
                                $dossierIds = $collection->filter(function ($item) use ($dateStart) {
                                    $valide = false;
                                    foreach ($item->devis as $devis) {
                                        foreach (($devis->data['trajets'] ?? []) as $trajet) {
                                            if ($trajet['aller_date_depart'] ?? false) {
                                                $trajetDepart = Carbon::parse($trajet['aller_date_depart']);
                                                if ($dateStart->equalTo($trajetDepart->startOfDay())) {
                                                    $valide = true;
                                                }
                                            }
                                        }
                                    }

                                    return $valide;
                                })->pluck('id');

                                return $query->whereIn('id', $dossierIds);
                            },
                        );
                }),
            Tables\Filters\Filter::make('retour')
                ->form([
                    DatePicker::make('retour')->label('Retour'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['retour'],
                            function(Builder $query, $date){
                                $dateRetour = Carbon::parse($date)->startOfDay();

                                $collection = $query->with('devis')->get();
                                $dossierIds = $collection->filter(function ($item) use ($dateRetour) {
                                    $valide = false;
                                    foreach ($item->devis as $devis) {
                                        foreach (($devis->data['trajets'] ?? []) as $trajet) {
                                            if ($trajet['retour_date_depart'] ?? false) {
                                                $trajetRetour = Carbon::parse($trajet['retour_date_depart']);
                                                if ($dateRetour->equalTo($trajetRetour->startOfDay())) {
                                                    $valide = true;
                                                }
                                            }
                                        }
                                    }
                                    return $valide;
                                })->pluck('id');

                                return $query->whereIn('id', $dossierIds);
                            }
                        );
                }),

        ];


        if(\Auth::user()->isSuperAdmin()){
            $filters[] = Tables\Filters\SelectFilter::make('bureaux')
                ->options(fn() => Role::whereIn('id', config('crmautocar.bureaux_ids'))->pluck('name', 'id'))
                ->query(function (Builder $query, $data) {
                    if ($data['value'] ?? false) {
                        return $query->whereHas('commercial', function (Builder $query) use ($data) {
                            $query->where('id', '!=', 1);
                            $query->whereHas('roles', function (Builder $query) use ($data) {
                                $query->where('id', $data['value']);
                            });
                        });
                    }
                });

        }


        if(
            \Auth::user()->isSuperAdmin() ||
            \Auth::user()->can('changeCommercial', \Modules\CrmAutoCar\Models\Proformat::class)
        ) {

            array_unshift($filters, Tables\Filters\Filter::make('my_dossier')
                ->label('Voir mes dossiers')
                ->query(fn (Builder $query): Builder => $query->where('commercial_id', \Auth::user()->id)
                    ->orWhereHas('followers', function ($query) {
                        $query->where('user_id', \Auth::user()->id);
                    })));

            $filters[] = Tables\Filters\MultiSelectFilter::make('commercial')
                    ->options(fn() => Commercial::all()->pluck('format_name', 'id'))
                ->query(function ($query, $data) {
                    if (count($data['values']) > 0) {
                        return $query->whereIn('commercial_id', $data['values']);
                    }
                });
        }



        $filters[] = Tables\Filters\Filter::make('created_at')
            ->form([
                DatePicker::make('created_from')->label('Créer après'),
                DatePicker::make('created_until')->label('Créer avant'),
            ])
            ->query(function (Builder $query, array $data): Builder {
                return $query
                    ->when(
                        $data['created_from'],
                        fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                    )
                    ->when(
                        $data['created_until'],
                        fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                    );
            });

        $filters[] = Tables\Filters\Filter::make('date_signature')
                ->form([
                    DatePicker::make('signate_from')->label('Signé après'),
                    DatePicker::make('signate_until')->label('Signé avant'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['signate_from'],
                            fn(Builder $query, $date): Builder => $query->whereHas('devis', function (Builder $query) use ($date) {
                                $query->whereHas('proformat', function (Builder $query) use ($date) {
                                    $dateStart = Carbon::parse($date)->startOfDay();
                                    $query->whereDate('created_at', '>=', $dateStart);
                                });
                            }),
                        )
                        ->when(
                            $data['signate_until'],
                            fn(Builder $query, $date): Builder => $query->whereHas('devis', function (Builder $query) use ($date) {
                                $query->whereHas('proformat', function (Builder $query) use ($date) {
                                    $dateEnd = Carbon::parse($date)->endOfDay();
                                    $query->whereDate('created_at', '<=', $dateEnd);
                                });
                            }),
                        );
                });

        return $filters;
    }

    protected function getTableActions(): array
    {
        return [
            Tables\Actions\IconButtonAction::make('edit')
                ->label('Voir le dossier')
                ->url(fn(Dossier $record): string => route('dossiers.show', [$record->client, $record]))
                ->icon('heroicon-o-eye')
        ];
    }


    protected function getTableBulkActions(): array
    {
        return [
            ExportAction::make('export')
                ->label('Export en excel')
                ->withHeadings()
                ->withExportable(ExportDossier::class)
                ->icon('fileicon-microsoft-excel'),
            ListFormulaire::getActionBulkAttribution(),
        ];
    }

    public function render()
    {
        return view('crmautocar::livewire.datatable.list-dossier');
    }

}
