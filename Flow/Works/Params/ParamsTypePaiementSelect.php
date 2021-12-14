<?php

namespace Modules\CrmAutoCar\Flow\Works\Params;

use Modules\CoreCRM\Flow\Works\Params\ParamsNumber;
use Modules\CoreCRM\Flow\Works\Params\WorkFlowParams;

class ParamsTypePaiementSelect extends WorkFlowParams
{

    public function name(): string
    {
        return 'Type paiement';
    }

    public function describe(): string
    {
        return 'type de paiement';
    }

    function nameView(): string
    {
        return 'crmautocar::workflows.type-paiement-validation';
    }
}
