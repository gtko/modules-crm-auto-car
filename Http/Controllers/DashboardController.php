<?php

namespace Modules\CrmAutoCar\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Modules\BaseCore\Main\SideMenu;
use Modules\CoreCRM\Models\Client;

class DashboardController
{
    public function index()
    {
        return view('crmautocar::app.dashboard');
    }
}
