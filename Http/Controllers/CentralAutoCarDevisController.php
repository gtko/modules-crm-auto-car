<?php

namespace Modules\CrmAutoCar\Http\Controllers;


use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Http\Controllers\Controller;
use Modules\CrmAutoCar\Models\Brand;
use Modules\DevisAutoCar\Entities\DevisPrice;
use Modules\DevisAutoCar\Entities\DevisTrajetPrice;

class CentralAutoCarDevisController extends Controller
{
    public function index($devisId, DevisRepositoryContract $devisRep,)
    {
        $devis = $devisRep->fetchById($devisId);
        $brand = Brand::where('id','2')->first();
        $trajetid = null;
        $trajet = $this->devis->data['trajets'][$trajetid] ?? null;

        if($trajet){
            $price = (new DevisTrajetPrice($devis, $trajetid, $brand));
        }else {
            $price = (new DevisPrice($devis, $brand));
        }

        return view('crmautocar::central-auto-car-devis.index', compact('devis', 'brand', 'price'));
    }
}
