<?php

namespace Modules\CrmAutoCar\Flow\Works\Conditions;

use Modules\CoreCRM\Flow\Works\Conditions\WorkFlowCondition;
use Modules\CoreCRM\Flow\Works\Params\WorkFlowParams;
use Modules\CrmAutoCar\Flow\Works\Params\ParamsNombreJours;
use Modules\CrmAutoCar\Flow\Works\Params\ParamsSoldeSelect;
use Modules\CrmAutoCar\Flow\Works\Params\ParamsTypePaiementSelect;
use Modules\CrmAutoCar\Models\Proformat;

class ConditionClientSolde extends WorkFlowCondition
{

    public function param(): ?WorkFlowParams
    {
        return new (ParamsSoldeSelect::class);
    }

    public function getValue()
    {

        $data = $this->event->getData();

        $dossier = $data['dossier'];
        $proformats = Proformat::whereHas('devis', function($query) use ($dossier){
            $query->where('dossier_id', $dossier->id);
        })->get();

        $total = $proformats->sum('total');
        $totalPaid = 0;

        foreach($proformats as $proformat){
            $statusProformat = 'partiel';
            /** @var \Modules\CrmAutoCar\Entities\ProformatPrice $price */
            $price = $proformat->price;
            $totalPaid += $price->paid();
        }

        if($total === $totalPaid) return "complet";
        if($totalPaid === 0) return "aucun";

        return 'partiel';
    }

    public function conditions():array
    {
        return [
            '==' => 'Egal à',
            '!=' => 'Différent de',
        ];
    }

    public function name(): string
    {
        return 'Solde du client';
    }

    public function describe(): string
    {
        return 'Verifier le solde du client actuel pour la facture en cours';
    }
}
