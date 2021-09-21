<?php

namespace Modules\CrmAutoCar\Mail;

use Illuminate\Mail\Mailable;

class RoadmapFournisseurEmailMail extends Mailable
{
    public function __construct()
    {
        //
    }

    public function build()
    {
        return $this->markdown('crmautocar::emails.roadmap-fournisseur');
    }
}
