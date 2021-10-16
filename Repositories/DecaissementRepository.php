<?php

namespace Modules\CrmAutoCar\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Livewire\HydrationMiddleware\HydratePublicProperties;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Models\Dossier;
use Modules\CoreCRM\Models\Fournisseur;
use Modules\CrmAutoCar\Contracts\Repositories\DecaissementRepositoryContract;
use Modules\CrmAutoCar\Models\Decaissement;

class DecaissementRepository implements DecaissementRepositoryContract
{

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
        return Decaissement::whereHas('devis', function ($query) use ($dossier) {
            $query->whereHas('dossier', function ($query) use ($dossier) {
                $query->where('id', $dossier->id);
            });
        })->get();

    }

    public function getByDevis(): \Illuminate\Support\Collection
    {
        $list = Decaissement::with('devis')->get();
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
            if ($resteAPayer) {
                $list = $list->where('restant', '>', 0);
            } else {
                $list = $list->where('restant', '=', 0);
            }
        }

        if ($periodeStart !== '' && $periodeEnd !== '') {
            $list = $list->where('date', '>=', $periodeStart->startOfDay())
                ->where('date', '<=', $periodeEnd->endOfDay());

        }

        if ($deparStart !== '') {

            dd('no');

        }

        return $list;
    }
}
