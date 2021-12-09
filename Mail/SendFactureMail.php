<?php

namespace Modules\CrmAutoCar\Mail;

use Illuminate\Mail\Mailable;

class SendFactureMail extends Mailable
{
    public function __construct(
        public string $subjectMail = 'Votre facture n°15421',
    )
    {}

    public function build()
    {
        return $this->from('facturation@centrale-autocar.com')
            ->subject($this->subjectMail)
            ->markdown('crmautocar::emails.send-facture');
    }
}
