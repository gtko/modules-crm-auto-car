<?php

namespace Modules\CrmAutoCar\Mail;

use Illuminate\Mail\Mailable;

class SendPdfDevisClientMail extends Mailable
{
    public function __construct()
    {
        //
    }

    public function build()
    {
        return $this->markdown('crmautocar::emails.send-pdf-devis-client');
    }
}
