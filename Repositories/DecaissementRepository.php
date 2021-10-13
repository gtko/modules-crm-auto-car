<?php

namespace Modules\CrmAutoCar\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
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
        $decaissement->devi()->associate($devi);
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
        return Decaissement::whereHas('devis', function ($query) use ($dossier){
            $query->whereHas('dossier', function ($query) use ($dossier){
               $query->where('id', $dossier->id);
            });
        })->get();

    }
}
