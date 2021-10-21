<?php

namespace Modules\CrmAutoCar\Http\Controllers;

use Illuminate\Http\Request;
use Modules\BaseCore\Http\Controllers\Controller;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CrmAutoCar\Models\Invoice;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('crmautocar::invoices.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Invoice $invoices
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoices)
    {
        //
    }
}
