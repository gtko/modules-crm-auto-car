<?php

namespace Modules\CrmAutoCar\Flow\Works\Files;

use Modules\BaseCore\Contracts\Services\PdfContract;
use Modules\CoreCRM\Actions\Devis\GenerateLinkDevis;

class ProformatPdfFiles extends \Modules\CoreCRM\Flow\Works\Files\WorkFlowFiles
{

    public function content(): string
    {
        $proformat = $this->event->getData()['proformat'];

        $pdfService = app(PdfContract::class);
        $pdfService->setUrl(route('proformats.show', [$proformat]));

        return $pdfService->getContentPdf();
    }

    public function filename(): string
    {
        return 'proformat.pdf';
    }

    public function mimetype(): string
    {
        return 'application/pdf';
    }

    public function name(): string
    {
        return 'Facture Proformat PDF';
    }

    public function description(): string
    {
        return 'Génération de la facture proformat en PDF';
    }
}
