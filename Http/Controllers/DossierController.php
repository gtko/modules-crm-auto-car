<?php

namespace Modules\CrmAutoCar\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Http\Controllers\ClientController;

class DossierController extends \Modules\CoreCRM\Http\Controllers\DossierController
{
    public function index()
    {
       return view('crmautocar::dossiers.index');
    }

}
