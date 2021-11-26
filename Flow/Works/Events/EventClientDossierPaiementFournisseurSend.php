<?php

namespace Modules\CrmAutoCar\Flow\Works\Events;

use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAjouterTag;
use Modules\CoreCRM\Flow\Works\Actions\ActionsChangeStatus;
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierPaiementFournisseurSend;

class EventClientDossierPaiementFournisseurSend extends \Modules\CoreCRM\Flow\Works\Events\WorkFlowEvent
{

    public function name(): string
    {
        return 'Paiement fournisseur envoyé.';
    }

    public function describe(): string
    {
        return 'Ce déclenche quand un paiement est envoyer au fournisseur';
    }

    protected function prepareData(Attributes $flowAttribute): array
    {
        return [
            'devis' => $flowAttribute->getDevis(),
            'user' => $flowAttribute->getUser(),
            'fournisseur' => $flowAttribute->getFournisseur(),
            'dossier' => $flowAttribute->getDevis()->dossier,
            'Decaissement' =>  $flowAttribute->getDecaissement()->dossier,
        ];
    }

    public function listen(): array
    {
        return [
          ClientDossierPaiementFournisseurSend::class,
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
