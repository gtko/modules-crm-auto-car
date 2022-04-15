<?php

namespace Modules\CrmAutoCar\Http\Controllers;



use Modules\BaseCore\Http\Controllers\Controller;
use Modules\CrmAutoCar\Services\FilterBureau;

class StatistiqueController extends Controller
{


    public function index()
    {
        app(FilterBureau::class)->activateFilter();
        return view('crmautocar::statistiques.index');
    }
}
