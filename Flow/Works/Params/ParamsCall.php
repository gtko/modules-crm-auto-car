<?php

namespace Modules\CrmAutoCar\Flow\Works\Params;

use Modules\CoreCRM\Flow\Works\Params\WorkFlowParams;

class ParamsCall extends WorkFlowParams
{

    public function name(): string
    {
        return 'Appel';
    }

    public function describe(): string
    {
        return '';
    }

    public function getValue()
    {
        return $this->value;
    }


}
