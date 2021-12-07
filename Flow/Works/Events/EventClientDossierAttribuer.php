<?php

namespace Modules\CrmAutoCar\Flow\Works\Events;

use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAddNote;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAjouterTag;
use Modules\CoreCRM\Flow\Works\Actions\ActionsChangeStatus;
use Modules\CoreCRM\Flow\Works\Actions\ActionsSendNotification;
use Modules\CoreCRM\Flow\Works\CategoriesEventEnum;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionCountDevis;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionCountDossier;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionStatus;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionTag;
use Modules\CoreCRM\Flow\Works\Events\WorkFlowEvent;
use Modules\CoreCRM\Flow\Works\Variables\DossierVariable;
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierAttribuer;

class EventClientDossierAttribuer extends WorkFlowEvent
{

    public function name(): string
    {
        return 'Attribuer un dossier';
    }

    public function describe(): string
    {
        return 'Se declenche quand on attribue un dossier a un commercial';
    }

    public function category(): string
    {
        return CategoriesEventEnum::DOSSIER;
    }

    protected function prepareData(Attributes $flowAttribute): array
    {
        return [
            'dossier' => $flowAttribute->getDossier(),
            'commercial' => $flowAttribute->getCommercial(),
            'attributeur' => $flowAttribute->getAttributeur()
        ];
    }

    public function variables():array
    {
        return [
            (new DossierVariable($this)),

        ];
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

    public function listen(): array
    {
       return [
           ClientDossierAttribuer::class
       ];
    }

    public function actions(): array
    {
        return [
            ActionsChangeStatus::class,
            ActionsAjouterTag::class,
            ActionsSendNotification::class,
            ActionsAddNote::class
        ];
    }
}
