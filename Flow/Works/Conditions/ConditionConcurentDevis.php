<?php

namespace Modules\CrmAutoCar\Flow\Works\Conditions;

use Carbon\Carbon;
use Modules\CoreCRM\Flow\Works\Params\ParamsBoolean;
use Modules\CoreCRM\Flow\Works\Params\WorkFlowParams;
use Modules\CoreCRM\Flow\Works\WorkflowLog;
use Modules\CrmAutoCar\Flow\Works\Params\ParamsBrand;
use Modules\CrmAutoCar\Flow\Works\Params\ParamsNombreJours;

class ConditionConcurentDevis extends \Modules\CoreCRM\Flow\Works\Conditions\WorkFlowCondition
{

    public function param(): ?WorkFlowParams
    {
        return new (ParamsBrand::class);
    }

    public function getValue()
    {
        $data = $this->event->getData();
        $trajets = collect($data['devis']->data['trajets'][0]);

        $total = $trajets['brands'][$this->getValueTarget()] ?? 0;

        app(WorkflowLog::class)->SetSubMessage("Prix de la brand ".$this->getValueTarget()." " . print_r($total, true)."€");

        if($total > 0) return $this->getValueTarget();

        return null;
    }

    public function getValueTarget(){
        $param = $this->param();
        $param->setValue($this->valueTarget);
        return $param->getValue() ?? null;
    }

    public function name(): string
    {
        return 'Devis concurrent plus grand que 0€';
    }

    public function describe(): string
    {
        return 'Devis concurrent plus grand que 0€';
    }
}
