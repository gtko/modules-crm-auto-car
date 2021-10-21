<?php

namespace Modules\CrmAutoCar\Http\Controllers;

use App\Http\Controllers\Controller;

class VuePlateauController extends \Modules\CoreCRM\Http\Controllers\Controller
{
    public function index()
    {
        return view('crmautocar::vue-plateau.index');
    }
}
