<?php

namespace Modules\CrmAutoCar\Flow\Works\Events;

use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAjouterTag;
use Modules\CoreCRM\Flow\Works\Actions\ActionsChangeStatus;
use Modules\CoreCRM\Flow\Works\CategoriesEventEnum;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionCountDevis;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionCountDossier;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionStatus;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionTag;
use Modules\CoreCRM\Flow\Works\Events\WorkFlowEvent;
use Modules\CrmAutoCar\Flow\Attributes\ClientDevisExterneConsultation;

class EventClientDevisExterneConsultation extends WorkFlowEvent
{

    public function name(): string
    {
       return 'Devis consulté par le client.';
    }

    public function category():string
    {
        return CategoriesEventEnum::DEVIS;
    }

    public function conditions():array
    {
        return [
            ConditionCountDevis::class,
            ConditionCountDossier::class,
            ConditionStatus::class,
            ConditionTag::class
        ];
    }

    public function describe(): string
    {
        return 'Se déclenche quand le client à consulté le devis.';
    }

    protected function prepareData(Attributes $flowAttribute): array
    {
        return [
            'devis' => $flowAttribute->getDevis(),
            'dossier' => $flowAttribute->getDevis()->dossier
        ];
    }

    public function listen(): array
    {
        return [
          ClientDevisExterneConsultation::class
        ];
    }

    public function actions(): array
    {
           return [
                    ActionsChangeStatus::class,
                    ActionsAjouterTag::class
                ];
    }
}
