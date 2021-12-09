<?php

namespace Modules\CrmAutoCar\Flow\Works\Files;

use Modules\BaseCore\Contracts\Services\PdfContract;

class CguPdfFiles extends \Modules\CoreCRM\Flow\Works\Files\WorkFlowFiles
{

    public function content(): string
    {
        $pdfService = app(PdfContract::class);
        $pdfService->setUrl(route('cgv'));

        return $pdfService->getContentPdf();
    }

    public function filename(): string
    {
        return 'cgv.pdf';
    }

    public function mimetype(): string
    {
        return 'application/pdf';
    }

    public function name(): string
    {
        return 'CGU PDF';
    }

    public function description(): string
    {
        return 'Condition général en fichier PDF';
    }
}
