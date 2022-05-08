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
use Modules\CrmAutoCar\Contracts\Repositories\DemandeFournisseurRepositoryContract;
use Modules\CrmAutoCar\Http\Livewire\ListFormulaire;
use Modules\CrmAutoCar\Models\Dossier;
use Modules\CrmAutoCar\Models\Fournisseur;
use Modules\CrmAutoCar\Models\Tag;
use Modules\CrmAutoCar\Models\Traits\EnumStatusCancel;
use Modules\CrmAutoCar\Models\Traits\EnumStatusDemandeFournisseur;
use Modules\CrmAutoCar\Repositories\DossierAutoCarRepository;
use Modules\CrmAutoCar\Tables\Columns\BureauColumn;
use Modules\CrmAutoCar\Tables\Columns\DateVoyageColumn;
use Modules\CrmAutoCar\Tables\Columns\TagsTable;
use pxlrbt\FilamentExcel\Actions\ExportAction;
use Spatie\Permission\Models\Role;

class ListDemandeFournisseur extends Component implements Tables\Contracts\HasTable
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
        $this->repository =  app(DemandeFournisseurRepositoryContract::class);
    }

    protected function getTableQuery(): Builder
    {
        return $this->repository->newQuery()
            ->with('devis.dossier.client')
            ->whereHas('devis', function (Builder $query) {
                $query->has('dossier');
            });
    }


    protected function getTableColumns(): array
    {
        return [

            Tables\Columns\TextColumn::make('id')
                ->label('#')
                ->sortable()
                ->toggleable(true),

            Tables\Columns\TextColumn::make('devis.id')
                ->label('ID Devis')
                ->url(function(Model $record) {
                    return route('devis.edit', [$record->devis->dossier->client, $record->devis->dossier, $record->devis]);
                    })
                ->sortable()
                ->toggleable(true),

            Tables\Columns\TextColumn::make('devis.dossier.id')
                ->label('ID Dossier')
                ->url(function(Model $record) {
                    return route('dossiers.show', [$record->devis->dossier->client, $record->devis->dossier]);
                })
                ->sortable()
                ->toggleable(true),

            Tables\Columns\TextColumn::make('devis.dossier.client.format_name')
                ->label('Client')
                ->sortable()
                ->toggleable(true),

            Tables\Columns\TextColumn::make('fournisseur.company')
                ->label('Société')
                ->default('N/A')
                ->sortable()
                ->toggleable(true),

            Tables\Columns\TextColumn::make('status')
                ->label('Statut')
                ->sortable()
                ->toggleable(true),

            Tables\Columns\TextColumn::make('prix')
                ->label('Prix Fournisseur')
                ->formatStateUsing(function(Model $record) {
                    return ($record->prix ?? 0 ) . ' €';
                })
                ->sortable()
                ->toggleable(true),

            Tables\Columns\TextColumn::make("payer")
                ->label('Montant Réglé')
                ->formatStateUsing(function(Model $record) {
                    return ($record->payer ?? 0) . "€";
                })
                ->sortable()
                ->toggleable(true),

            Tables\Columns\TextColumn::make('reste')
                ->label('Reste à régler')
                ->formatStateUsing(function(Model $record) {
                    return ($record->reste ?? $record->prix) . "€";
                })
                ->sortable()
                ->toggleable(true),

            DateVoyageColumn::make('devis')
                ->label('Date du voyage')
                ->sortable()
                ->toggleable(true),

            Tables\Columns\TextColumn::make('decaissements_count')
                ->counts('decaissements')
                ->label('Nombre de paiement Fournisseur')
                ->sortable()
                ->toggleable(true),

        ];
    }

    protected function applySortingToTableQuery(Builder $query): Builder
    {
        if (filled($sortCol = $this->getTableSortColumn()) && filled($sortDir = $this->getTableSortDirection())) {

            $ordersBy = [
                'devis.dossier.client.format_name' => function ($query, $direction) {
                    $query->orderBy(function ($query) {
                        $query
                            ->select(DB::raw('CONCAT(personnes.firstname,personnes.lastname) as format_name'))
                            ->from('clients')
                            ->leftJoin('devis', 'devis.id', '=', 'devi_fournisseurs.devi_id')
                            ->leftJoin('dossiers', 'dossiers.id', '=', 'devis.dossier_id')
                            ->leftJoin('personnes', 'personnes.id', '=', 'clients.personne_id')
                            ->whereColumn('devis.id', 'devi_fournisseurs.devi_id')
                            ->limit(1);
                    }, $direction);
                },
                'fournisseur.company' => function ($query, $direction) {
                    $query->orderBy(function ($query) {
                        $query
                            ->select('data->company')
                            ->from('users')
                            ->whereColumn('users.id', 'devi_fournisseurs.user_id')
                            ->limit(1);
                    }, $direction);
                },
                'devis' => function ($query, $direction) {
                    $query->orderBy(function ($query) {
                        $query->from('devis')
                            ->selectRaw("json_unquote(json_extract(`data`, '$.trajets[0].aller_date_depart'))")
                            ->whereColumn(
                                'devis.id',
                                'devi_fournisseurs.devi_id'
                            )
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


    protected function getTableRecordUrlUsing(): \Closure
    {
        return fn(Model $record): string => route('dossiers.show', ['client' => $record->devis->dossier->client, 'dossier' => $record->devis->dossier]);
    }

    protected function getTableFiltersFormColumns(): int
    {
        return 4;
    }

    protected function getTableFilters(): array
    {
        $filters = [
            Tables\Filters\MultiSelectFilter::make('status')
                ->options([
                    EnumStatusDemandeFournisseur::STATUS_BPA => 'BPA',
                    EnumStatusDemandeFournisseur::STATUS_VALIDATE => 'Validé',
                    EnumStatusDemandeFournisseur::STATUS_REFUSED => 'Refusé',
                    EnumStatusCancel::STATUS_CANCELED => 'Annulé',
                    EnumStatusCancel::STATUS_CANCELLER => 'Remboursement',
                ])
                ->column('status'),
            Tables\Filters\MultiSelectFilter::make('fournisseur')
                ->options(function (): array {
                    return Fournisseur::all()->pluck('company', 'id')->toArray();
                })
                ->column('user_id'),
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
                                $demandeIDs = $collection->filter(function ($item) use ($dateStart) {
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

                                return $query->whereIn('id', $demandeIDs);
                            },
                        );
                }),
        ];

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
        return $filters;
    }

    protected function getTableActions(): array
    {
        return [
            Tables\Actions\IconButtonAction::make('edit')
                ->label('Voir le dossier')
                ->url(fn(Model $record): string => route('dossiers.show', [$record->devis->dossier->client, $record->devis->dossier]))
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
        return view('crmautocar::livewire.datatable.list-demande-fournisseur');
    }

}
