<?php

namespace Modules\CrmAutoCar\Flow\Works\Conditions;

use Modules\CoreCRM\Flow\Works\Conditions\WorkFlowCondition;
use Modules\CoreCRM\Flow\Works\Params\WorkFlowParams;
use Modules\CrmAutoCar\Flow\Works\Params\ParamsNombreJours;
use Modules\CrmAutoCar\Flow\Works\Params\ParamsSoldeSelect;
use Modules\CrmAutoCar\Flow\Works\Params\ParamsTypePaiementSelect;

class ConditionFournisseurSolde extends WorkFlowCondition
{

    public function param(): ?WorkFlowParams
    {
        return new (ParamsSoldeSelect::class);
    }

    public function getValue()
    {
        $data = $this->event->getData();

//        //
//        $fournisseurs =  $data['proformat']
//
//        $price =  $data['proformat']->price;
//        if($price->paid() >= $price->getPriceTTC()) return 'complet';
//        if($price->paid() === 0) return 'aucun';

        return 'complet';
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
        return 'Solde du / des fournisseurs';
    }

    public function describe(): string
    {
        return 'Verifier le solde du/des fournisseurs actuel';
    }
}
