<?php

namespace Modules\CrmAutoCar\Flow\Works\Files;

use Modules\BaseCore\Contracts\Services\PdfContract;
use Modules\CoreCRM\Actions\Devis\GenerateLinkDevis;
use Modules\CoreCRM\Flow\Works\Files\WorkFlowFiles;

class DevisBrand2PdfFiles extends WorkFlowFiles
{

    public function content(): string
    {
        $devis = $this->event->getData()['devis'];

        $pdfService = app(PdfContract::class);
        $pdfService->setUrl(route('brand2', $devis));

        return $pdfService->getContentPdf();
    }

    public function filename(): string
    {
        return 'louer-un-bus-offre.pdf';
    }

    public function mimetype(): string
    {
        return 'application/pdf';
    }

    public function name(): string
    {
        return 'Devis louerunbus.fr';
    }

    public function description(): string
    {
        return 'génération du fichier devis mon autocar en pdf';
    }
}
