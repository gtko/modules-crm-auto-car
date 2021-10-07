<?php

namespace Modules\CrmAutoCar\Actions;

use Illuminate\Support\Facades\Mail;
use Modules\CrmAutoCar\Mail\RequestFournisseurMail;

class SendRequestFournisseurMail
{

    public function send($mail, $dossier, $content, $subject)
    {
        Mail::to($mail)->bcc(\Auth::user()->email)->send(new RequestFournisseurMail($dossier, $content, $subject));
    }

}
