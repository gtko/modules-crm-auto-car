<?php

namespace Modules\CrmAutoCar\Mail;

use Illuminate\Mail\Mailable;

class AccepteDevisConseillerMail extends Mailable
{
    public function __construct()
    {
        //
    }

    public function build()
    {
        return $this->markdown('crmautocar::emails.accepte-devis-conseiller');
    }
}
