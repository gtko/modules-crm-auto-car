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
        if($data['devis']->validate) {
            $trajets = collect($data['devis']->data['trajets']);

            //on cherche le plus petit nombre de jours
            $jours = $trajets->map(function ($item) {
                $depart = Carbon::parse($item['aller_date_depart']);
                if($depart->greaterThan(now())) {
                    return ['diff' => now()->diffInHours($depart)];
                }

                return 24*365*50;
            });

            // 24 / 24 = 1
            // 26 / 24 = 1,08
            // 48 / 24 = 2
            // 47 / 24 = 1,96
            // 49 / 24 = 2,04 NON
            // 50 / 24 = 2,08 NON


            return $jours->min('diff') / 24;
        }

        return 365*50;
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
