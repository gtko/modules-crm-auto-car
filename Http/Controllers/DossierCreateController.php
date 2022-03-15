<?php

namespace Modules\CrmAutoCar\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\CoreCRM\Models\Client;
use Modules\CrmAutoCar\Models\Dossier;

class DossierCreateController extends \Modules\CoreCRM\Http\Controllers\Controller
{
    public function index(Client $client)
    {

        return view('crmautocar::dossier-create', compact('client'));
    }

    public function edit(Dossier $dossier)
    {
        $client = $dossier->client;
        return view('crmautocar::dossier-create', compact('client', 'dossier'));
    }
}
