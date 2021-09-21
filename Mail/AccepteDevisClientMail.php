<?php

namespace Modules\CrmAutoCar\Mail;

use Illuminate\Mail\Mailable;

class AccepteDevisClientMail extends Mailable
{
    public function __construct()
    {
        //
    }

    public function build()
    {
        return $this->markdown('crmautocar::emails.accepte-devis-client');
    }
}
