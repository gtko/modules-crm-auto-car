<?php

namespace Modules\CrmAutoCar\Http\Livewire\Datatable;

use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\MultiSelectFilter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Modules\CrmAutoCar\Contracts\Repositories\DemandeFournisseurRepositoryContract;
use Modules\CrmAutoCar\Models\Fournisseur;
use Modules\CrmAutoCar\Models\Traits\EnumStatusCancel;
use Modules\CrmAutoCar\Models\Traits\EnumStatusDemandeFournisseur;

class StatFournisseurDatatableQuery
{
    protected $repository = null;

    public function __construct()
    {
        $this->repository =  app(DemandeFournisseurRepositoryContract::class);
    }

    public function getTableQuery(): Builder
    {
        return $this->repository->newQuery()
            ->with('devis.dossier.client')
            ->where(function ($query) {
                $query->has('fournisseur')
//                ->where('status', '=', EnumStatusDemandeFournisseur::STATUS_BPA)
                ->whereHas('devis', function (Builder $query) {
                    $query->whereHas('dossier', function ($query) {
                        $query->whereNotBetween("id", [3585,22564]);
                    });
                });
            });
    }

    public function getTableFilters(): array
    {
        $filters = [
            SelectFilter::make('status')
                ->options([
                    EnumStatusDemandeFournisseur::STATUS_BPA => 'BPA',
                    EnumStatusDemandeFournisseur::STATUS_VALIDATE => 'Validé',
                    EnumStatusDemandeFournisseur::STATUS_REFUSED => 'Refusé',
                    EnumStatusCancel::STATUS_CANCELED => 'Annulé',
                    EnumStatusCancel::STATUS_CANCELLER => 'Remboursement',
                ])
                ->default(EnumStatusDemandeFournisseur::STATUS_BPA)
                ->attribute('status'),

            MultiSelectFilter::make('fournisseur')
                ->options(function (): array {
                    return Fournisseur::all()->pluck('company', 'id')->toArray();
                })
                ->attribute('user_id'),

            Filter::make('depart')
                ->form([
                    DatePicker::make('depart')->label('Départ'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['depart'],
                            function (Builder $query, $date) {
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

        $filters[] = Filter::make('created_at')
            ->form([
                DatePicker::make('created_from')->label('Créer après'),
                DatePicker::make('created_until')->label('Créer avant'),
            ])
            ->query(function (Builder $query, array $data): Builder {
                return $query
                    ->when(
                        $data['created_from'],
                        fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                    )
                    ->when(
                        $data['created_until'],
                        fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                    );
            });
        return $filters;
    }
}
