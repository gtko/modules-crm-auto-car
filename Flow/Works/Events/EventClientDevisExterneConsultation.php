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
use Modules\CoreCRM\Flow\Works\Variables\DeviVariable;
use Modules\CoreCRM\Flow\Works\Variables\DossierVariable;
use Modules\CoreCRM\Flow\Works\Variables\UserVariable;
use Modules\CrmAutoCar\Flow\Attributes\ClientDevisExterneConsultation;
use Modules\CrmAutoCar\Flow\Works\Conditions\ConditionDateDepartDevis;
use Modules\CrmAutoCar\Flow\Works\Files\CguPdfFiles;
use Modules\CrmAutoCar\Flow\Works\Files\DevisPdfFiles;
use Modules\CrmAutoCar\Flow\Works\Files\InformationVoyagePdfFiles;
use Modules\CrmAutoCar\Flow\Works\Files\ProformatPdfFiles;
use Modules\CrmAutoCar\Flow\Works\Files\RIBPdfFiles;
use Modules\CrmAutoCar\Flow\Works\Variables\GestionnaireVariable;
use Modules\CrmAutoCar\Flow\Works\Variables\InformationVoyageVariable;

class EventClientDevisExterneConsultation extends WorkFlowEvent
{

    public function name(): string
    {
       return 'Devis consulté par le client.';
    }

    public function category():string
    {
        return CategoriesEventEnum::DEVIS;
    }

    public function conditions():array
    {
        return [
            ConditionCountDevis::class,
            ConditionCountDossier::class,
            ConditionStatus::class,
            ConditionTag::class,
            ConditionDateDepartDevis::class
        ];
    }

    public function describe(): string
    {
        return 'Se déclenche quand le client à consulté le devis.';
    }

    protected function prepareData(Attributes $flowAttribute): array
    {
        return [
            'devis' => $flowAttribute->getDevis(),
            'dossier' => $flowAttribute->getDevis()->dossier,
            'client' => $flowAttribute->getDevis()->dossier->client,
            'commercial' => $flowAttribute->getDevis()->dossier->commercial,
        ];
    }

    public function files():array
    {
        return [
            (new DevisPdfFiles($this)),
            (new CguPdfFiles($this)),
            (new RIBPdfFiles($this)),
            (new InformationVoyagePdfFiles($this)),
        ];
    }

    public function variables():array
    {
        return [
            (new DossierVariable($this)),
            (new DeviVariable($this)),
            (new CommercialVariable($this)),
            (new GestionnaireVariable($this)),
            (new ClientVariable($this)),
            (new InformationVoyageVariable($this)),
        ];
    }

    public function listen(): array
    {
        return [
          ClientDevisExterneConsultation::class
        ];
    }

}
