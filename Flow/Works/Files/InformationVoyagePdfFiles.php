<?php

namespace Modules\CrmAutoCar\Flow\Works\Files;

use Modules\BaseCore\Actions\Url\SigneRoute;
use Modules\BaseCore\Contracts\Services\PdfContract;
use Modules\CoreCRM\Actions\Devis\GenerateLinkDevis;
use Modules\CoreCRM\Flow\Works\Files\WorkFlowFiles;

class InformationVoyagePdfFiles extends WorkFlowFiles
{

    public function content(): string
    {
        $devis = $this->event->getData()['devis'];

        $pdfService = app(PdfContract::class);
        $pdfService->setUrl((new SigneRoute())->signer('feuille-route', [$devis]));

        return $pdfService->getContentPdf();
    }

    public function filename(): string
    {
        return 'feuille-de-route.pdf';
    }

    public function mimetype(): string
    {
        return 'application/pdf';
    }

    public function name(): string
    {
        return 'Feuille de route PDF';
    }

    public function description(): string
    {
        return 'génération du fichier de la feuille de route en PDF';
    }
}
