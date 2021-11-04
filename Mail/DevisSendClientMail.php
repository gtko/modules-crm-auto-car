<?php

namespace Modules\CrmAutoCar\Mail;

use Illuminate\Mail\Mailable;
use Modules\CoreCRM\Actions\Devis\GenerateLinkDevis;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;

class DevisSendClientMail extends Mailable
{


    public function __construct(public DevisEntities $devis,
                                public string $subjectMail = 'Proposition de tarif'){}

    public function build()
    {
        return $this->subject($this->subjectMail)
            ->markdown('crmautocar::emails.send-devis-client',[
                'link' => (new GenerateLinkDevis())->GenerateLink($this->devis)
            ]);
    }
}
