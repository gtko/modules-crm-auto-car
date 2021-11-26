<?php

namespace Modules\CrmAutoCar\Flow\Works\Events;

use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAddNote;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAjouterTag;
use Modules\CoreCRM\Flow\Works\Actions\ActionsChangeStatus;
use Modules\CoreCRM\Flow\Works\Events\WorkFlowEvent;
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierDemandeFournisseurSend;

class EventClientDossierDemandeFournisseurSend extends WorkFlowEvent
{

    public function name(): string
    {
        return "Envoie de la demande fournisseur";
    }

    public function describe(): string
    {
        return "Se declenche quand on envoie une demande au fournisseur dans la fiche cliente.";
    }

    protected function prepareData(Attributes $flowAttribute): array
    {
        return [
            'devis' => $flowAttribute->getDevis(),
            'dossier' => $flowAttribute->getDevis()->dossier,
            'fournisseur' => $flowAttribute->getFournisseur(),
            'user' => $flowAttribute->getUser()
        ];
    }

    public function listen(): array
    {
        return [
           ClientDossierDemandeFournisseurSend::class
        ];
    }

    public function actions(): array
    {
        return [
           ActionsChangeStatus::class,
           ActionsAjouterTag::class,
           ActionsAddNote::class
        ];
    }
}
