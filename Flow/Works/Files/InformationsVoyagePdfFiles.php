<?php

namespace Modules\CrmAutoCar\Flow\Works\Files;

use Modules\BaseCore\Actions\Url\SigneRoute;
use Modules\BaseCore\Contracts\Services\PdfContract;
use Modules\CoreCRM\Actions\Devis\GenerateLinkDevis;
use Modules\CoreCRM\Flow\Works\Files\WorkFlowFiles;

class InformationsVoyagePdfFiles extends WorkFlowFiles
{

    public function content(): string
    {
        $devis = $this->event->getData()['devis'];

        $pdfService = app(PdfContract::class);
        $pdfService->setUrl((new SigneRoute())->signer('info-voyage.show', [$devis]));

        return $pdfService->getContentPdf();
    }

    public function filename(): string
    {
        return 'information-voyage.pdf';
    }

    public function mimetype(): string
    {
        return 'application/pdf';
    }

    public function name(): string
    {
        return 'Informations voyage PDF';
    }

    public function description(): string
    {
        return 'génération du fichier des informations voyage en PDF';
    }
}
