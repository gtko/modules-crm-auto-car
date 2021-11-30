<?php

namespace Modules\CrmAutoCar\Http\Controllers;


use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Http\Controllers\Controller;
use Modules\CoreCRM\Services\FlowCRM;
use Modules\CrmAutoCar\Flow\Attributes\ClientDevisExterneConsultation;
use Modules\CrmAutoCar\Models\Brand;

class MonAutoCarDevisController extends Controller
{
    public function index($devisId, DevisRepositoryContract $devisRep)
    {
        $devis = $devisRep->fetchById($devisId);
        $brand = Brand::first();

        return view('crmautocar::mon-auto-car-devis.index', compact('devis', 'brand'));
    }
}
