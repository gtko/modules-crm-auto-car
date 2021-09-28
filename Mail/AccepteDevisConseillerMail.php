<?php

namespace Modules\CrmAutoCar\Mail;

use Illuminate\Mail\Mailable;

class AccepteDevisConseillerMail extends Mailable
{


    public function __construct(
       public string $subjectMail = 'Devis validé par le client',
    )
    {}

    public function build()
    {
        return $this->subject($this->subjectMail)->markdown('crmautocar::emails.accepte-devis-conseiller');
    }
}
