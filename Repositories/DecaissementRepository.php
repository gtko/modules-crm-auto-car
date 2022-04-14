<?php

namespace Modules\CrmAutoCar\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Livewire\HydrationMiddleware\HydratePublicProperties;
use Modules\BaseCore\Repositories\AbstractRepository;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Models\Dossier;
use Modules\CoreCRM\Models\Fournisseur;
use Modules\CrmAutoCar\Contracts\Repositories\DecaissementRepositoryContract;
use Modules\CrmAutoCar\Models\Decaissement;
use phpDocumentor\Reflection\Types\Parent_;

class DecaissementRepository extends AbstractRepository implements DecaissementRepositoryContract
{

    public function newQuery():Builder
    {
        if(Auth::check() && $this->isAllBureau() && !$this->isSearchActivate()) {
            $bureaux = Auth::user()->roles->whereIn('id', config('crmautocar.bureaux_ids'));
            return parent::newQuery()->whereHas('devis', function ($query) use ($bureaux) {
                $query->whereHas('commercial', function ($query) use ($bureaux) {
                    $query->whereHas('roles', function ($query) use ($bureaux) {
                        $query->whereIn('id', $bureaux->pluck('id'));
                    });
                });
            });
        }

        return parent::newQuery();
    }

    public function create(DevisEntities $devi, Fournisseur $fournisseur, float $payer, float $reste, Carbon $date): Decaissement
    {

        $decaissement = new Decaissement();
        $decaissement->payer = $payer;
        $decaissement->restant = $reste;
        $decaissement->date = $date;
        $decaissement->devis()->associate($devi);
        $decaissement->fournisseur()->associate($fournisseur);
        $decaissement->save();

        return $decaissement;
    }

    public function getPayer(DevisEntities $devi, Fournisseur $fournisseur): ?float
    {
        $paiements = Decaissement::where('devis_id', $devi->id)->where('fournisseur_id', $fournisseur->id)->orderBy('id', 'desc')->get();
        $dejaPayer = 0;
        foreach ($paiements as $paiement) {
            $dejaPayer = $dejaPayer + $paiement->payer;
        }

        return $dejaPayer;
    }

    public function getByDossier(Dossier $dossier): Collection
    {
        return $this->newQuery()->whereHas('devis', function ($query) use ($dossier) {
            $query->whereHas('dossier', function ($query) use ($dossier) {
                $query->where('id', $dossier->id);
            });
        })->get();
    }

    public function getByDevis(): \Illuminate\Support\Collection
    {
        $list = $this->newQuery()->with('devis')->get();
        $list = $list->groupBy('devis_id', 'fournisseur_id');
        $newList = collect();
        foreach ($list as $listFiltre) {

            $newList->push($listFiltre->last());
        }
        return $newList;
    }

    public function getByFiltre(Fournisseur|string $fournisseur, bool|string $resteAPayer, Carbon|string $periodeStart, Carbon|string $periodeEnd, Carbon|string $deparStart): \Illuminate\Support\Collection
    {
        $list = $this->getByDevis();

        if ($fournisseur !== '') {
            $list = $list->where('fournisseur_id', $fournisseur->id);
        }

        if ($resteAPayer !== '') {
            if($resteAPayer === 'troppayer'){
                $list = $list->where('restant', '<', 0);
            }else {
                if ($resteAPayer) {
                    $list = $list->where('restant', '>', 0);
                } else {
                    $list = $list->where('restant', '=', 0);
                }
            }
        }

        if ($periodeStart !== '' && $periodeEnd !== '') {
            $list = $list->where('date', '>=', $periodeStart->startOfDay())
                ->where('date', '<=', $periodeEnd->endOfDay());

        }

        if ($deparStart !== '') {

            $newList = collect();
            foreach ($list as $listFiltre) {
                if (isset($listFiltre->devis->data['aller_date_depart']) && Carbon::createFromTimeString($listFiltre->devis->data['aller_date_depart'])->startOfDay() == $deparStart) {

                    $newList->push($listFiltre);

                }

            }

            $list = $newList;
        }
        return $list;
    }

    public function getTotalResteARegler(array $decaissements): float
    {
        $restant = collect($decaissements)->sum('restant') ?? 0.00;
        if($restant > 0){
            return $restant;
        }

        return 0;
    }

    public function getTotalDejaRegler(array $decaissements): float
    {
        return collect($decaissements)->sum('payer') ?? 0.00;
    }

    public function getCountNombrePaiement(Decaissement $decaissement): int
    {
        return $this->newQuery()->where('fournisseur_id', $decaissement->fournisseur_id)->where('devis_id', $decaissement->devis_id)->count();
    }

    public function getDetailPaiement(Decaissement $decaissement): Collection
    {
        return $this->newQuery()->where('fournisseur_id', $decaissement->fournisseur_id)->where('devis_id', $decaissement->devis_id)->get();
    }

    public function getModel(): Model
    {
        return new Decaissement();
    }

    public function searchQuery(Builder $query, string $value, mixed $parent = null): Builder
    {
        return $query;
    }
}
