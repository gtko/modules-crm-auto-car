<?php

namespace Modules\CrmAutoCar\Http\Controllers;

use Illuminate\Http\Request;
use Modules\CrmAutoCar\Contracts\Repositories\ProformatsRepositoryContract;
use Modules\CrmAutoCar\Models\Proformat;

class ProformatsController extends \Modules\CoreCRM\Http\Controllers\Controller
{

    public function __construct(
        public ProformatsRepositoryContract $proformatRep
    ){}

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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Proformat $proformat)
    {
        return view('crmautocar::proformats.show', compact('proformat'));
    }
}
