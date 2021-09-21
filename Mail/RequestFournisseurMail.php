<?php

namespace Modules\CrmAutoCar\Mail;

use Illuminate\Mail\Mailable;

class RequestFournisseurMail extends Mailable
{
    public function __construct()
    {
        //
    }

    public function build()
    {
        return $this->markdown('crmautocar::emails.request-fournisseur');
    }
}
