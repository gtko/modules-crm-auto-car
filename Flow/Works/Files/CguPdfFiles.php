<?php

namespace Modules\CrmAutoCar\Flow\Works\Files;

use Illuminate\Support\Facades\Storage;
use Modules\CoreCRM\Flow\Works\Files\WorkFlowFiles;

class CguPdfFiles extends WorkFlowFiles
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
