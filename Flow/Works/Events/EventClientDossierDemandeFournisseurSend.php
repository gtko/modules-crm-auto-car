<?php

namespace Modules\CrmAutoCar\Flow\Works\Events;

use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAddNote;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAjouterTag;
use Modules\CoreCRM\Flow\Works\Actions\ActionsChangeStatus;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionCountDevis;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionCountDossier;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionStatus;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionTag;
use Modules\CoreCRM\Flow\Works\Events\WorkFlowEvent as WorkFlowEventAlias;
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierDemandeFournisseurSend;

class EventClientDossierDemandeFournisseurSend extends WorkFlowEventAlias
{

    public function name(): string
    {
        return 'Demande fournisseur envoyée.';
    }

    public function category():string
    {
        return 'Fournisseur';
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
           ClientDossierDemandeFournisseurSend::class,
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
