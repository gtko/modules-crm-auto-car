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
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierAddTag;
use Modules\CrmAutoCar\Flow\Attributes\DevisSendClient;
use Modules\CrmAutoCar\Flow\Attributes\SendEmailDossier;
use Modules\CrmAutoCar\Flow\Attributes\SendInformationVoyageMailClient;
use Modules\CrmAutoCar\Flow\Attributes\SendProformat;
use Modules\CrmAutoCar\Flow\Works\Conditions\ConditionDateDepartDevis;
use Modules\CrmAutoCar\Flow\Works\Files\CguPdfFiles;
use Modules\CrmAutoCar\Flow\Works\Files\DevisBrand1PdfFiles;
use Modules\CrmAutoCar\Flow\Works\Files\DevisBrand2PdfFiles;
use Modules\CrmAutoCar\Flow\Works\Files\DevisPdfFiles;
use Modules\CrmAutoCar\Flow\Works\Files\FeuilleDeRoutePdfFiles;
use Modules\CrmAutoCar\Flow\Works\Files\InformationsVoyagePdfFiles;
use Modules\CrmAutoCar\Flow\Works\Files\ProformatPdfFiles;
use Modules\CrmAutoCar\Flow\Works\Files\RIBPdfFiles;
use Modules\CrmAutoCar\Flow\Works\Variables\ClientValidationVariable;
use Modules\CrmAutoCar\Flow\Works\Variables\GestionnaireVariable;
use Modules\CrmAutoCar\Flow\Works\Variables\InformationVoyageVariable;
use Modules\CrmAutoCar\Flow\Works\Variables\ProformatVariable;
use Modules\CrmAutoCar\Flow\Works\Variables\TagVariable;

class EventSendInformationVoyageMailClient extends WorkFlowEvent
{

    public function name(): string
    {
        return "Envoie des informations voyages au client";
    }

    public function category():string
    {
        return 'Proforma';
    }

    public function describe(): string
    {
        return "Se déclenche quand on envoie les informations coyage au client manuellement";
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

    protected function prepareData(Attributes $flowAttribute): array
    {
        $proformat = $flowAttribute->getProformat();
        $user = $flowAttribute->getUser();
        return [
            'dossier' => $proformat->devis->dossier,
            'devis' => $proformat->devis,
            'proformat' => $proformat,
            'client' => $proformat->devis->dossier->client,
            'commercial' => $proformat->devis->dossier->commercial,
            'user' => $user,
        ];
    }

    public function files():array
    {
        return [
            (new CguPdfFiles($this)),
            (new RIBPdfFiles($this)),
            (new DevisPdfFiles($this)),
            (new ProformatPdfFiles($this)),
            (new FeuilleDeRoutePdfFiles($this)),
            (new InformationsVoyagePdfFiles($this))
        ];
    }

    public function variables():array
    {
        return [
            (new DossierVariable($this)),
            (new ProformatVariable($this)),
            (new DeviVariable($this)),
            (new CommercialVariable($this)),
            (new GestionnaireVariable($this)),
            (new ClientVariable($this)),
            (new UserVariable($this)),
            (new ClientValidationVariable($this)),
            (new InformationVoyageVariable($this)),
        ];
    }

    public function listen(): array
    {
        return [
            SendInformationVoyageMailClient::class
        ];
    }

}
