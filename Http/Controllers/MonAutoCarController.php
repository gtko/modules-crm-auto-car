<?php

namespace Modules\CrmAutoCar\Http\Controllers;


use Modules\BaseCore\Http\Controllers\Controller;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CrmAutoCar\Models\Brand;
use Modules\DevisAutoCar\Entities\DevisPrice;
use Modules\DevisAutoCar\Entities\DevisTrajetPrice;

class MonAutoCarController extends Controller
{
    public function index($devisId, DevisRepositoryContract $devisRep,)
    {
        $devis = $devisRep->fetchById($devisId);
        $brand = Brand::where('id','3')->first();
        $trajetid = null;
        $trajet = $this->devis->data['trajets'][$trajetid] ?? null;

        if($trajet){
            $price = (new DevisTrajetPrice($devis, $trajetid, $brand));
        }else {
            $price = (new DevisPrice($devis, $brand));
        }
        return (view('crmautocar::mon-autocar.index', compact('devis', 'brand', 'price')));
    }
}
