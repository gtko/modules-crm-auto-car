<?php

namespace Modules\CrmAutoCar\Flow\Works\Events;

use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAjouterTag;
use Modules\CoreCRM\Flow\Works\Actions\ActionsChangeStatus;
use Modules\CoreCRM\Flow\Works\Events\WorkFlowEvent as WorkFlowEventAlias;
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierDemandeFournisseurSend;

class EventClientDossierDemandeFournisseurSend extends WorkFlowEventAlias
{

    public function name(): string
    {
        return 'Demande fournisseur envoyée.';
    }

    public function describe(): string
    {
        return 'Se déclenche quand une demande fournisseur est envoyé.';
    }

    protected function prepareData(Attributes $flowAttribute): array
    {
        return [
            'devis' => $flowAttribute->getDevis(),
            'user' => $flowAttribute->getUser(),
            'fournisseur' => $flowAttribute->getFournisseur(),
            'dossier' => $flowAttribute->getDevis()->dossier
        ];
    }

    public function listen(): array
    {
        return [
           ClientDossierDemandeFournisseurSend::class,
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
