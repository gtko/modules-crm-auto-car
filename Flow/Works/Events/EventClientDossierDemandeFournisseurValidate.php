<?php

namespace Modules\CrmAutoCar\Flow\Works\Events;

use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAjouterTag;
use Modules\CoreCRM\Flow\Works\Actions\ActionsChangeStatus;
use Modules\CoreCRM\Flow\Works\Events\WorkFlowEvent;
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierDemandeFournisseurValidate;

class EventClientDossierDemandeFournisseurValidate extends WorkFlowEvent
{

    public function name(): string
    {
        return 'Demande fournisseur validée.';
    }

    public function describe(): string
    {
        return 'Ce déclenche quand une demande fournisseur est validée.';

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
          ClientDossierDemandeFournisseurValidate::class
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
