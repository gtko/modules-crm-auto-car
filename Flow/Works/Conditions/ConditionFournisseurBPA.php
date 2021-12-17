<?php

namespace Modules\CrmAutoCar\Flow\Works\Conditions;

use Carbon\Carbon;
use Modules\CoreCRM\Flow\Works\Conditions\WorkFlowConditionBoolean;
use Modules\CoreCRM\Flow\Works\Params\ParamsBoolean;
use Modules\CoreCRM\Flow\Works\Params\WorkFlowParams;
use Modules\CoreCRM\Models\Dossier;
use Modules\CrmAutoCar\Flow\Works\Params\ParamsNombreJours;
use Modules\CrmAutoCar\Models\Fournisseur;

class ConditionFournisseurBPA extends WorkFlowConditionBoolean
{

    public function param(): ?WorkFlowParams
    {
        return new (ParamsBoolean::class);
    }

    public function getValue()
    {
        $data = $this->event->getData();

        $fournisseurs = collect();

        foreach($data['dossier']->devis as $devis){
            $fournisseurs = $fournisseurs->merge($devis->fournisseurs);
        }

        return $fournisseurs->count() === $fournisseurs->sum('pivot.bpa');
    }

    public function name(): string
    {
        return 'Tous les fournisseurs BPA';
    }

    public function describe(): string
    {
        return 'vérifie si tous les fournisseurs sont en BPA';
    }
}
