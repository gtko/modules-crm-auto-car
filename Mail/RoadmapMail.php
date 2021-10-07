<?php

namespace Modules\CrmAutoCar\Mail;

use Illuminate\Mail\Mailable;

class RoadmapMail extends Mailable
{
    public function __construct(
        public string $subjectMail = 'Votre feuille de route',
    )
    {}

    public function build()
    {
        return $this->subject($this->subjectMail)->markdown('crmautocar::emails.roadmap');
    }
}
