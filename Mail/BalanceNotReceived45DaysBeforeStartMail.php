<?php

namespace Modules\CrmAutoCar\Mail;

use Illuminate\Mail\Mailable;

class BalanceNotReceived45DaysBeforeStartMail extends Mailable
{
    public function __construct(
        public string $subjectMail = 'Relance régement solde j-45 devis #15122',
    )
    {}

    public function build()
    {
        return $this->subject($this->subjectMail)->markdown('crmautocar::emails.balance-not-received-45-days-before-start');
    }
}
