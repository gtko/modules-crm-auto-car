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
        $fournisseurs = Fournisseur::whereHas('devis' , function($query) use($data){
            $query->whereHas('dossier', function($query) use($data){
                $query->where('id', $data['dossier']->id);
            });
        })->get();

        return $fournisseurs->count() == $fournisseurs->where('bpa', true)->count();
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
