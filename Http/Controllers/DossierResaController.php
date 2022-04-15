<?php

namespace Modules\CrmAutoCar\Http\Controllers;

use Modules\CrmAutoCar\Services\FilterBureau;

class DossierResaController
{
    public function index()
    {
        app(FilterBureau::class)->activateFilter();
        return view('crmautocar::dossier-resa.index');
    }
}
