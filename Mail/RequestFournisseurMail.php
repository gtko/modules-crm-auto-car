<?php

namespace Modules\CrmAutoCar\Mail;

use Illuminate\Mail\Mailable;
use Modules\CoreCRM\Models\Dossier;

class RequestFournisseurMail extends Mailable
{
    public function __construct(
        public Dossier $dossier,
        public string $message = '',
    )
    {}

    public function build()
    {
       $subjectMail = 'Demande de transfert (n°' . $this->dossier->ref . ')';

        return $this->subject($subjectMail)->markdown('crmautocar::emails.request-fournisseur');
    }
}
