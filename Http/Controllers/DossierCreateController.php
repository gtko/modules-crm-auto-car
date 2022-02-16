<?php

namespace Modules\CrmAutoCar\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\CoreCRM\Models\Client;

class DossierCreateController extends \Modules\CoreCRM\Http\Controllers\Controller
{
    public function index(Client $client)
    {

        return view('crmautocar::dossier-create', compact('client'));
    }
}
