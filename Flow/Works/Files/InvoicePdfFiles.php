<?php

namespace Modules\CrmAutoCar\Flow\Works\Files;

use Modules\BaseCore\Actions\Url\SigneRoute;
use Modules\BaseCore\Contracts\Services\PdfContract;
use Modules\CoreCRM\Actions\Devis\GenerateLinkDevis;

class InvoicePdfFiles extends \Modules\CoreCRM\Flow\Works\Files\WorkFlowFiles
{

    public function content(): string
    {
        $invoice = $this->event->getData()['invoice'];

        $pdfService = app(PdfContract::class);
        $pdfService->setUrl((new SigneRoute())->signer('invoices.show', [$invoice]));

        return $pdfService->getContentPdf();
    }

    public function filename(): string
    {
        return 'facture.pdf';
    }

    public function mimetype(): string
    {
        return 'application/pdf';
    }

    public function name(): string
    {
        return 'Facture PDF';
    }

    public function description(): string
    {
        return 'Génération de la facture en PDF';
    }
}
