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
use Modules\CoreCRM\Flow\Works\Events\WorkFlowEvent;
use Modules\CoreCRM\Flow\Works\Variables\ClientVariable;
use Modules\CoreCRM\Flow\Works\Variables\CommercialVariable;
use Modules\CoreCRM\Flow\Works\Variables\DossierVariable;
use Modules\CoreCRM\Flow\Works\Variables\UserVariable;
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierAttribuer;
use Modules\CrmAutoCar\Flow\Works\Files\CguPdfFiles;
use Modules\CrmAutoCar\Flow\Works\Files\DevisPdfFiles;
use Modules\CrmAutoCar\Flow\Works\Files\ProformatPdfFiles;

class EventClientDossierAttribuer extends WorkFlowEvent
{

    public function name(): string
    {
        return 'Attribuer un dossier';
    }

    public function describe(): string
    {
        return 'Se declenche quand on attribue un dossier a un commercial';
    }

    public function category(): string
    {
        return CategoriesEventEnum::DOSSIER;
    }

    protected function prepareData(Attributes $flowAttribute): array
    {
        return [
            'dossier' => $flowAttribute->getDossier(),
            'client' => $flowAttribute->getDossier()->client,
            'commercial' => $flowAttribute->getCommercial(),
            'user' => $flowAttribute->getAttributeur(),
        ];
    }

    public function files():array
    {
        return [
            (new CguPdfFiles($this)),
        ];
    }

    public function variables():array
    {
        return [
            (new DossierVariable($this)),
            (new CommercialVariable($this)),
            (new UserVariable($this)),
            (new ClientVariable($this)),
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
           ClientDossierAttribuer::class
       ];
    }

}
