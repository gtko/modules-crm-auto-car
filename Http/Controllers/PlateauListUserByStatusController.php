<?php

namespace Modules\CrmAutoCar\Http\Controllers;

use App\Http\Controllers\Controller;

class PlateauListUserByStatusController extends \Modules\CoreCRM\Http\Controllers\Controller
{
    public function index($commercial_id, $status_id)
    {
        return view('crmautocar::vue-plateau.index-list', compact(['commercial_id', 'status_id']));
    }
}
