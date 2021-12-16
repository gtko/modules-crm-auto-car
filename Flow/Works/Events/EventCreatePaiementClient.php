<?php

namespace Modules\CrmAutoCar\Flow\Works\Events;

use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAddCall;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAddNote;
use Modules\CoreCRM\Flow\Works\Actions\ActionsAjouterTag;
use Modules\CoreCRM\Flow\Works\Actions\ActionsChangeStatus;
use Modules\CoreCRM\Flow\Works\Actions\ActionsSendNotification;
use Modules\CoreCRM\Flow\Works\Actions\ActionsSupprimerTag;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionCountDevis;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionCountDossier;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionStatus;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionTag;
use Modules\CoreCRM\Flow\Works\Variables\ClientVariable;
use Modules\CoreCRM\Flow\Works\Variables\CommercialVariable;
use Modules\CoreCRM\Flow\Works\Variables\DeviVariable;
use Modules\CoreCRM\Flow\Works\Variables\DossierVariable;
use Modules\CrmAutoCar\Flow\Attributes\CreatePaiementClient;
use Modules\CrmAutoCar\Flow\Attributes\CreateProformatClient;
use Modules\CrmAutoCar\Flow\Works\Conditions\ConditionClientTypeValidation;
use Modules\CrmAutoCar\Flow\Works\Conditions\ConditionDateDepartDevis;
use Modules\CrmAutoCar\Flow\Works\Files\CguPdfFiles;
use Modules\CrmAutoCar\Flow\Works\Files\DevisBrand1PdfFiles;
use Modules\CrmAutoCar\Flow\Works\Files\DevisBrand2PdfFiles;
use Modules\CrmAutoCar\Flow\Works\Files\DevisPdfFiles;
use Modules\CrmAutoCar\Flow\Works\Files\InformationVoyagePdfFiles;
use Modules\CrmAutoCar\Flow\Works\Files\ProformatPdfFiles;
use Modules\CrmAutoCar\Flow\Works\Variables\ClientValidationVariable;
use Modules\CrmAutoCar\Flow\Works\Variables\PaiementVariable;
use Modules\CrmAutoCar\Flow\Works\Variables\ProformatVariable;

class EventCreatePaiementClient extends \Modules\CoreCRM\Flow\Works\Events\WorkFlowEvent
{

    public function name(): string
    {
        return 'Paiement du client';
    }

    public function category():string
    {
        return 'Paiement';
    }

    public function describe(): string
    {
        return 'Se déclenche quand un paiement est effectué.';
    }

    public function conditions():array
    {
        return [
            ConditionCountDevis::class,
            ConditionCountDossier::class,
            ConditionStatus::class,
            ConditionTag::class,
            ConditionDateDepartDevis::class,
            ConditionClientTypeValidation::class
        ];
    }

    protected function prepareData(Attributes $flowAttribute): array
    {
        return [
            'payment' => $flowAttribute->getPayment(),
            'invoice' => $flowAttribute->getPayment()->invoice,
            'devis' => $flowAttribute->getPayment()->invoice->devis,
            'dossier' =>  $flowAttribute->getPayment()->invoice->devis->dossier,
            'commercial' => $flowAttribute->getPayment()->invoice->devis->commercial,
            'client' => $flowAttribute->getPayment()->invoice->devis->dossier->client,
            'proformat' => $flowAttribute->getPayment()->invoice->devis->proformat,
        ];
    }

    public function files():array
    {
        return [
            (new DevisPdfFiles($this)),
            (new CguPdfFiles($this)),
            (new ProformatPdfFiles($this)),
            (new DevisBrand1PdfFiles($this)),
            (new DevisBrand2PdfFiles($this)),
            (new InformationVoyagePdfFiles($this)),
        ];
    }

    public function variables():array
    {
        return [
            (new DossierVariable($this)),
            (new DeviVariable($this)),
            (new CommercialVariable($this)),
            (new ClientVariable($this)),
            (new ProformatVariable($this)),
            (new PaiementVariable($this)),
            (new ClientValidationVariable($this)),
        ];
    }


    public function listen(): array
    {
        return [
            CreatePaiementClient::class
        ];
    }

    public function actions(): array
    {
        return [
            ActionsChangeStatus::class,
            ActionsAjouterTag::class,
            ActionsSendNotification::class,
            ActionsAddNote::class,
            ActionsSupprimerTag::class,
            ActionsAddCall::class
        ];
    }
}