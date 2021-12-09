<?php

namespace Modules\CrmAutoCar\Flow\Works\Files;

use Modules\BaseCore\Contracts\Services\PdfContract;
use Modules\CoreCRM\Actions\Devis\GenerateLinkDevis;
use Modules\CoreCRM\Flow\Works\Files\WorkFlowFiles;

class DevisBrand1PdfFiles extends WorkFlowFiles
{

    public function content(): string
    {
        $devis = $this->event->getData()['devis'];

        $pdfService = app(PdfContract::class);
        $pdfService->setUrl(route('brand1', $devis));

        return $pdfService->getContentPdf();
    }

    public function filename(): string
    {
        return 'devis'.now()->format('d-m-Y').'location-car.pdf';
    }

    public function mimetype(): string
    {
        return 'application/pdf';
    }

    public function name(): string
    {
        return 'Devis location car';
    }

    public function description(): string
    {
        return 'génération du fichier devis location car  en pdf';
    }
}
