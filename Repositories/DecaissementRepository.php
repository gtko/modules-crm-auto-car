<?php

namespace Modules\CrmAutoCar\Repositories;

use Carbon\Carbon;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Models\Fournisseur;
use Modules\CrmAutoCar\Contracts\Repositories\DecaissementRepositoryContract;
use Modules\CrmAutoCar\Models\Decaissement;

class DecaissementRepository implements DecaissementRepositoryContract
{

    public function create(DevisEntities $devi, Fournisseur $fournisseur, float $payer, float $reste, Carbon $date): Decaissement
    {
        $decaissement = new Decaissement();
        $decaissement->payer = $payer;
        $decaissement->reste = $reste;
        $decaissement->date = $date;
        $decaissement->devi()->attach($devi);
        $decaissement->fournisseur()->attach($fournisseur);
        $decaissement->save();

        return $decaissement;
    }
}
