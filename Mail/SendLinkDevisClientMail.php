<?php

namespace Modules\CrmAutoCar\Mail;

use Illuminate\Mail\Mailable;

class SendLinkDevisClientMail extends Mailable
{
    public function __construct()
    {
        //
    }

    public function build()
    {
        return $this->markdown('crmautocar::emails.send-link-devis-client');
    }
}
