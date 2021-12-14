<?php

namespace Modules\CrmAutoCar\Flow\Works\Conditions;

use Carbon\Carbon;
use Modules\CoreCRM\Flow\Works\Params\WorkFlowParams;
use Modules\CrmAutoCar\Flow\Works\Params\ParamsNombreJours;

class ConditionDateDepartDevis extends \Modules\CoreCRM\Flow\Works\Conditions\WorkFlowCondition
{

    public function param(): ?WorkFlowParams
    {
        return new (ParamsNombreJours::class);
    }

    public function getValue()
    {
        $data = $this->event->getData();
        $trajets = collect($data['devis']->data['trajets']);

        //on cherche le plus petit nombre de jours
        $jours = $trajets->map(function($item) {
            return ['diff' => now()->diffInDays(Carbon::parse($item['aller_date_depart']))];
        });

        return $jours->min('diff');
    }

    public function name(): string
    {
        return 'Nombre de jours avant le départ';
    }

    public function describe(): string
    {
        return 'Nombre de jours avant le départ';
    }
}
