<?php

namespace Modules\CrmAutoCar\Http\Controllers;



use Modules\BaseCore\Http\Controllers\Controller;

class StatistiqueController extends Controller
{


    public function index()
    {
        return view('crmautocar::statistiques.index');
    }
}
