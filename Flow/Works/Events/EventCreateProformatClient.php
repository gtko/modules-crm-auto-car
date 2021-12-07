<?php

namespace Modules\CrmAutoCar\Flow\Works\Events;

use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAjouterTag;
use Modules\CoreCRM\Flow\Works\Actions\ActionsChangeStatus;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionCountDevis;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionCountDossier;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionStatus;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionTag;
use Modules\CrmAutoCar\Flow\Attributes\CreateProformatClient;

class EventCreateProformatClient extends \Modules\CoreCRM\Flow\Works\Events\WorkFlowEvent
{

    public function name(): string
    {
        return 'Proformat créé';
    }

    public function category():string
    {
        return 'Proformat';
    }

    public function describe(): string
    {
        return 'Se déclenche quand une facture proformat est crée.';
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

    protected function prepareData(Attributes $flowAttribute): array
    {
        return [
            'proformat' => $flowAttribute->getProformat(),
            'devis' => $flowAttribute->getProformat()->devis,
            'dossier' =>  $flowAttribute->getProformat()->devis->dossier,
        ];
    }

    public function listen(): array
    {
        return [
            CreateProformatClient::class
        ];
    }

    public function actions(): array
    {
        return [
            ActionsChangeStatus::class,
            ActionsAjouterTag::class,
        ];
    }
}