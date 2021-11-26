<?php

namespace Modules\CrmAutoCar\Flow\Works\Events;

use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAjouterTag;
use Modules\CoreCRM\Flow\Works\Actions\ActionsChangeStatus;
use Modules\CoreCRM\Flow\Works\Events\WorkFlowEvent;
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierDemandeFournisseurDelete;

class EventClientDossierDemandeFournisseurDelete extends WorkFlowEvent
{

    public function name(): string
    {
        return 'Demande fournisseur supprimer';
    }

    public function describe(): string
    {
        return 'Se declanche quand une demande fournisseur est supprimer';
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
            ClientDossierDemandeFournisseurDelete::class
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
