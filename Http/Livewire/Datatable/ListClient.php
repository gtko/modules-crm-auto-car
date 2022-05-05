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
use Modules\CoreCRM\Contracts\Repositories\ClientRepositoryContract;
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

class ListClient extends Component implements Tables\Contracts\HasTable
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
        $this->repository =  app(ClientRepositoryContract::class);
    }

    protected function getTableQuery(): Builder
    {
        return $this->repository->newQuery();
    }


    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\ImageColumn::make('avatar_url')
                ->label('')
                ->rounded(true),
            Tables\Columns\TextColumn::make('format_name')
                ->label('Client')
                ->sortable()
                ->searchable()
                ->toggleable(true),

            Tables\Columns\TextColumn::make('company')
                ->label('Société')
                ->default('N/A')
                ->sortable()
                ->searchable()
                ->toggleable(true),

            Tables\Columns\TextColumn::make('email')
                ->label('Email')
                ->sortable()
                ->searchable()
                ->toggleable(true),

            Tables\Columns\TextColumn::make('phone')
                ->label('Téléphone')
                ->sortable()
                ->searchable()
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
                'signature_at' => function ($query, $direction) {
                    $query->orderBy(function ($query) {
                        $query
                            ->select('proformats.created_at')
                            ->from('devis')
                            ->join('proformats', 'devis.id', '=', 'proformats.devis_id')
                            ->join('dossiers', 'devis.dossier_id', '=', 'dossiers.id')
                            ->whereColumn('dossiers.clients_id', 'clients.id')
                            ->orderBy('proformats.created_at', 'asc')
                            ->limit(1);
                    }, $direction);
                },
                'format_name' => function ($query, $direction) {
                    $query->orderBy(function ($query) {
                        $query
                            ->select(DB::raw('CONCAT(personnes.firstname,personnes.lastname) as format_name'))
                            ->from('personnes')
                            ->whereColumn('clients.personne_id', 'personnes.id')
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
        return fn(Model $record): string => route('clients.show', ['client' => $record]);
    }

    protected function getTableFiltersFormColumns(): int
    {
        return 4;
    }

    protected function getDefaultStatusProperty(){
        return ['4','7','8','9'];
    }

    protected function getTableFilters(): array
    {
        $filters = [
            Tables\Filters\MultiSelectFilter::make('tag')
                ->options(fn() => Tag::all()->pluck('label', 'id'))
                ->query(function ($query, $data) {
                    if (count($data['values']) > 0) {
                        return
                        $query->whereHas('dossiers', function (Builder $query) use ($data) {
                            $query->whereHas('tags', function (Builder $query) use ($data) {
                                $query->whereIn('tag_id', $data['values']);
                            });
                        });
                    }
                }),

        ];


        if(\Auth::user()->isSuperAdmin()){
            $filters[] = Tables\Filters\SelectFilter::make('bureaux')
                ->options(fn() => Role::whereIn('id', config('crmautocar.bureaux_ids'))->pluck('name', 'id'))
                ->query(function (Builder $query, $data) {
                    if ($data['value'] ?? false) {
                        return
                            $query->whereHas('dossiers', function (Builder $query) use ($data) {
                                $query->whereHas('commercial', function (Builder $query) use ($data) {
                                    $query->where('id', '!=', 1);
                                    $query->whereHas('roles', function (Builder $query) use ($data) {
                                        $query->where('id', $data['value']);
                                    });
                            });
                        });
                    }
                });

        }

        $filters[] = Tables\Filters\Filter::make('date_signature')
            ->form([
                DatePicker::make('signate_from')->label('Signé après'),
                DatePicker::make('signate_until')->label('Signé avant'),
            ])
            ->query(function (Builder $query, array $data): Builder {
                return $query
                    ->when(
                        $data['signate_from'],
                        fn(Builder $query, $date): Builder =>
                        $query->whereHas('dossiers', function (Builder $query) use ($date) {
                            $query->whereHas('devis', function (Builder $query) use ($date) {
                                $query->whereHas('proformat', function (Builder $query) use ($date) {
                                    $dateStart = Carbon::parse($date)->startOfDay();
                                    $query->whereDate('created_at', '>=', $dateStart);
                                });
                            });
                        }),
                    )
                    ->when(
                        $data['signate_until'],
                        fn(Builder $query, $date): Builder =>
                        $query->whereHas('dossiers', function (Builder $query) use ($date) {
                            $query->whereHas('devis', function (Builder $query) use ($date) {
                                $query->whereHas('proformat', function (Builder $query) use ($date) {
                                    $dateEnd = Carbon::parse($date)->endOfDay();
                                    $query->whereDate('created_at', '<=', $dateEnd);
                                });
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
                ->label('Voir le client')
                ->url(fn($record): string => route('clients.show', [$record]))
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
        return view('crmautocar::livewire.datatable.list-client');
    }

}
