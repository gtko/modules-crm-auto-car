<?php

namespace Modules\CrmAutoCar\Flow\Works\Conditions;

use Modules\CoreCRM\Flow\Works\Conditions\WorkFlowCondition;
use Modules\CoreCRM\Flow\Works\Params\WorkFlowParams;
use Modules\CrmAutoCar\Flow\Works\Params\ParamsNombreJours;
use Modules\CrmAutoCar\Flow\Works\Params\ParamsSoldeSelect;
use Modules\CrmAutoCar\Flow\Works\Params\ParamsTypePaiementSelect;

class ConditionClientSolde extends WorkFlowCondition
{

    public function param(): ?WorkFlowParams
    {
        return new (ParamsSoldeSelect::class);
    }

    public function getValue()
    {
        $data = $this->event->getData();
        /** @var \Modules\CrmAutoCar\Entities\ProformatPrice $price */
        $price =  $data['proformat']->price;
        if($price->paid() >= $price->getPriceTTC()) return 'complet';
        if($price->paid() === 0) return 'aucun';

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
