<?php

namespace Modules\CrmAutoCar\Mail;

use Illuminate\Mail\Mailable;

class BalanceNotReceived45DaysBeforeStartMail extends Mailable
{
    public function __construct()
    {
        //
    }

    public function build()
    {
        return $this->markdown('crmautocar::emails.balance-not-received-45-days-before-start');
    }
}
