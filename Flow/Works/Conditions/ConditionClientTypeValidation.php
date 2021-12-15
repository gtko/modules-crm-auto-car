<?php

namespace Modules\CrmAutoCar\Flow\Works\Conditions;

use Modules\CoreCRM\Flow\Works\Conditions\WorkFlowCondition;
use Modules\CoreCRM\Flow\Works\Params\WorkFlowParams;
use Modules\CrmAutoCar\Flow\Works\Params\ParamsNombreJours;
use Modules\CrmAutoCar\Flow\Works\Params\ParamsTypePaiementSelect;

class ConditionClientTypeValidation extends WorkFlowCondition
{

    public function param(): ?WorkFlowParams
    {
        return new (ParamsTypePaiementSelect::class);
    }

    public function getValue()
    {
        $data = $this->event->getData();

        return $data['devis']->data['paiement_type_validation'] ?? '';
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
        return 'Type de paiement demandé';
    }

    public function describe(): string
    {
        return 'Type de paiement que le client demande';
    }
}
