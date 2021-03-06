<?php

namespace Modules\CrmAutoCar\Mail;

use Illuminate\Mail\Mailable;
use Modules\CoreCRM\Actions\Devis\GenerateLinkDevis;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;

class AccepteDevisClientMail extends Mailable
{


    public function __construct(
        public DevisEntities $devis,
        public string $ip,
        public string $subjectMail = 'Votre devis Centrale Autocar',
    )
    {}

    public function build()
    {
        return $this->subject($this->subjectMail)->markdown('crmautocar::emails.accepte-devis-client', [
            'devisUrl' => (new GenerateLinkDevis())->GenerateLink($this->devis),
            'proformatUrl' => route('proformats.show', $this->devis->proformat)
        ]);
    }
}
