<?php

namespace Modules\CrmAutoCar\Flow\Works\Files;

use Modules\BaseCore\Contracts\Services\PdfContract;

class CguPdfFiles extends \Modules\CoreCRM\Flow\Works\Files\WorkFlowFiles
{

    public function content(): string
    {
        return Storage::get('cgl.pdf');
    }

    public function filename(): string
    {
        return 'cgl.pdf';
    }

    public function mimetype(): string
    {
        return 'application/pdf';
    }

    public function name(): string
    {
        return 'CGL PDF';
    }

    public function description(): string
    {
        return 'Condition général en fichier PDF';
    }
}
