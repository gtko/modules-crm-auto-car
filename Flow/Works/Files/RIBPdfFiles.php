<?php

namespace Modules\CrmAutoCar\Flow\Works\Files;

use Illuminate\Support\Facades\Storage;
use Modules\CoreCRM\Flow\Works\Files\WorkFlowFiles;

class RIBPdfFiles extends WorkFlowFiles
{

    public function content(): string
    {
        return Storage::get('rib.pdf');
    }

    public function filename(): string
    {
        return 'rib.pdf';
    }

    public function mimetype(): string
    {
        return 'application/pdf';
    }

    public function name(): string
    {
        return 'RIB';
    }

    public function description(): string
    {
        return 'Rib de centrale autocar';
    }
}
