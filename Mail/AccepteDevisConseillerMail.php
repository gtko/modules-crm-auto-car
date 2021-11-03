<?php

namespace Modules\CrmAutoCar\Mail;

use Illuminate\Mail\Mailable;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;

class AccepteDevisConseillerMail extends Mailable
{


    public function __construct(
        public DevisEntities $devis,
        public string $ip,
        public string $subjectMail = 'Devis validé par le client',
    )
    {}

    public function build()
    {
        return $this->subject($this->subjectMail)->markdown('crmautocar::emails.accepte-devis-conseiller');
    }
}
