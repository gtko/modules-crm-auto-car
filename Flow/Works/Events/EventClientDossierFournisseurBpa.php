<?php

namespace Modules\CrmAutoCar\Flow\Works\Events;

use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAddCall;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAddNote;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAjouterTag;
use Modules\CoreCRM\Flow\Works\Actions\ActionsChangeStatus;
use Modules\CoreCRM\Flow\Works\Actions\ActionsSendNotification;
use Modules\CoreCRM\Flow\Works\Actions\ActionsSupprimerTag;
use Modules\CoreCRM\Flow\Works\CategoriesEventEnum;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionCountDevis;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionCountDossier;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionStatus;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionTag;
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierFournisseurBpa;
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierPaiementFournisseurSend;
use Modules\CrmAutoCar\Flow\Works\Conditions\ConditionDateDepartDevis;
use Modules\CrmAutoCar\Flow\Works\Conditions\ConditionFournisseurBPA;
use Modules\CrmAutoCar\Flow\Works\Files\CguPdfFiles;
use Modules\CrmAutoCar\Flow\Works\Files\DevisPdfFiles;
use Modules\CrmAutoCar\Flow\Works\Files\InformationVoyagePdfFiles;
use Modules\CrmAutoCar\Flow\Works\Files\ProformatPdfFiles;

class EventClientDossierFournisseurBpa extends \Modules\CoreCRM\Flow\Works\Events\WorkFlowEvent
{

    public function name(): string
    {
        return 'Fournisseur BPA.';
    }

    public function category():string
    {
        return 'Fournisseur';
    }

    public function describe(): string
    {
        return 'Ce déclenche quand un BPA fournisseur est reçu';
    }

    public function conditions():array
    {
        return [
            ConditionCountDevis::class,
            ConditionCountDossier::class,
            ConditionStatus::class,
            ConditionTag::class,
            ConditionDateDepartDevis::class,
            ConditionFournisseurBPA::class
        ];
    }

    protected function prepareData(Attributes $flowAttribute): array
    {
        return [
            'devis' => $flowAttribute->getDevis(),
            'user' => $flowAttribute->getUser(),
            'fournisseur' => $flowAttribute->getFournisseur(),
            'dossier' => $flowAttribute->getDevis()->dossier,
        ];
    }

    public function files():array
    {
        return [
            (new DevisPdfFiles($this)),
            (new CguPdfFiles($this)),
            (new InformationVoyagePdfFiles($this)),
        ];
    }

    public function listen(): array
    {
        return [
          ClientDossierFournisseurBpa::class,
        ];
    }

}
