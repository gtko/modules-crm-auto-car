<?php

namespace Modules\CrmAutoCar\Mail;

use Illuminate\Mail\Mailable;
use Modules\CoreCRM\Actions\Devis\GenerateLinkDevis;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;

class DevisSendClientMail extends Mailable
{


    public function __construct(public DevisEntities $devis, $subject = 'Proposition de tarif'){}

    public function build()
    {
        return $this->subject($this->subject)
            ->markdown('crmautocar::emails.send-devis-client',[
                'link' => (new GenerateLinkDevis())->GenerateLink($this->devis)
            ]);
    }
}
