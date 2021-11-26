<?php

namespace Modules\CrmAutoCar\Flow\Works\Events;

use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAjouterTag;
use Modules\CoreCRM\Flow\Works\Actions\ActionsChangeStatus;
use Modules\CoreCRM\Flow\Works\Events\WorkFlowEvent;
use Modules\CrmAutoCar\Flow\Attributes\DevisSendClient;

class EventDevisSendClient extends WorkFlowEvent
{

    public function name(): string
    {
        return 'Devis envoyé';
    }

    public function describe(): string
    {
        return "Se déclenche quand un devis est envoyé au client";
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
            DevisSendClient::class
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