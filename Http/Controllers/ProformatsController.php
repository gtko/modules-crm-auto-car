<?php

namespace Modules\CrmAutoCar\Http\Controllers;

use Illuminate\Http\Request;
use Modules\CrmAutoCar\Models\Proformat;

class ProformatsController extends \Modules\CoreCRM\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('crmautocar::proformats.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Proformat $proformat
     * @return \Illuminate\Http\Response
     */
    public function show(Proformat $proformat)
    {
        //
    }
}
