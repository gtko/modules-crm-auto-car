<?php

namespace Modules\CrmAutoCar\Http\Controllers;


use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Http\Controllers\Controller;
use Modules\CoreCRM\Services\FlowCRM;
use Modules\CrmAutoCar\Flow\Attributes\ClientDevisExterneConsultation;
use Modules\CrmAutoCar\Models\Brand;
use Modules\DevisAutoCar\Entities\DevisPrice;
use Modules\DevisAutoCar\Entities\DevisTrajetPrice;

class MonAutoCarDevisController extends Controller
{
    public function index($devisId, DevisRepositoryContract $devisRep,)
    {
        $devis = $devisRep->fetchById($devisId);
        $brand = Brand::first();
        $trajetid = null;
        $trajet = $this->devis->data['trajets'][$trajetid] ?? null;

        if($trajet){
            $price = (new DevisTrajetPrice($devis, $trajetid, $brand));
        }else {
            $price = (new DevisPrice($devis, $brand));
        }

        return view('crmautocar::mon-auto-car-devis.index', compact('devis', 'brand', 'price'));
    }
}
