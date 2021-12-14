<?php

namespace Modules\CrmAutoCar\Flow\Works\Params;

use Modules\CoreCRM\Flow\Works\Params\ParamsNumber;

class ParamsNombreJours extends ParamsNumber
{

    public function name(): string
    {
        return 'Nombre de jours';
    }

}
