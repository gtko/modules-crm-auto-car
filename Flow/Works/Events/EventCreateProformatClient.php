<?php

namespace Modules\CrmAutoCar\Flow\Works\Events;

use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAjouterTag;
use Modules\CoreCRM\Flow\Works\Actions\ActionsChangeStatus;
use Modules\CrmAutoCar\Flow\Attributes\CreateProformatClient;

class EventCreateProformatClient extends \Modules\CoreCRM\Flow\Works\Events\WorkFlowEvent
{

    public function name(): string
    {
        return 'Proformat créé';
    }

    public function describe(): string
    {
        return 'Se déclenche quand une facture proformat est crée.';
    }

    protected function prepareData(Attributes $flowAttribute): array
    {
        return [
            'proformat' => $flowAttribute->getProformat(),
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
