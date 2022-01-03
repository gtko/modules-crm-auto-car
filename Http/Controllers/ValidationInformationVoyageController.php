<?php

namespace Modules\CrmAutoCar\Http\Controllers;

use Modules\CoreCRM\Contracts\Entities\DevisEntities;

class ValidationInformationVoyageController
{
    public function index(DevisEntities $devis)
    {
        return view('crmautocar::ValidationinformationVoyage', compact("devis"));
    }
}
