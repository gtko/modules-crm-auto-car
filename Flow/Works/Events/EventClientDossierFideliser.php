<?php

namespace Modules\CrmAutoCar\Flow\Works\Events;

use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Works\Variables\ClientVariable;
use Modules\CoreCRM\Flow\Works\Variables\CommercialVariable;
use Modules\CoreCRM\Flow\Works\Variables\DeviVariable;
use Modules\CoreCRM\Flow\Works\Variables\DossierVariable;
use Modules\CoreCRM\Flow\Works\Variables\FournisseurVariable;
use Modules\CoreCRM\Flow\Works\Variables\UserVariable;
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierFideliser;
use Modules\CrmAutoCar\Flow\Works\Files\CguPdfFiles;
use Modules\CrmAutoCar\Flow\Works\Files\DevisPdfFiles;
use Modules\CrmAutoCar\Flow\Works\Files\InformationVoyagePdfFiles;
use Modules\CrmAutoCar\Flow\Works\Files\RIBPdfFiles;
use Modules\CrmAutoCar\Flow\Works\Variables\GestionnaireVariable;

class EventClientDossierFideliser extends \Modules\CoreCRM\Flow\Works\Events\WorkFlowEvent
{

    public function name(): string
    {
        return 'Dossier fidéliser';
    }

    public function describe(): string
    {
        return 'Evénement quand le dossier est fidéliser';
    }

    protected function prepareData(Attributes $flowAttribute): array
    {
        $dossier = $flowAttribute->getDossier();
        return [
            'dossier' => $dossier,
            'client' => $dossier->client,
            'commercial' => $dossier->commercial,
        ];
    }

    public function variables():array
    {
        return [
            (new DossierVariable($this)),
            (new CommercialVariable($this)),
            (new ClientVariable($this)),
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

    public function listen(): array
    {
        return [
            ClientDossierFideliser::class
        ];
    }
}
