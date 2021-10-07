<?php

namespace Modules\CrmAutoCar\Mail;

use Illuminate\Mail\Mailable;
use Modules\CoreCRM\Models\Dossier;

class RequestFournisseurMail extends Mailable
{
    public function __construct(
        public Dossier $dossier,
        public string $message = '',
        public string $subjectMail = '',
    )
    {}

    public function build()
    {
        return $this->subject($this->subjectMail)->markdown('crmautocar::emails.request-fournisseur');
    }
}
