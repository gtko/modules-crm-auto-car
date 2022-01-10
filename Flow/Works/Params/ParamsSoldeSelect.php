<?php

namespace Modules\CrmAutoCar\Flow\Works\Params;

use Modules\CoreCRM\Flow\Works\Params\ParamsNumber;
use Modules\CoreCRM\Flow\Works\Params\WorkFlowParams;

class ParamsSoldeSelect extends WorkFlowParams
{

    public function name(): string
    {
        return 'Solde';
    }

    public function describe(): string
    {
        return 'Solde de la facture' ;
    }

    function nameView(): string
    {
        return 'crmautocar::workflows.solde-select';
    }
}
