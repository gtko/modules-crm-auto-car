<?php

namespace Modules\CrmAutoCar\Http\Controllers;

use Modules\BaseCore\Http\Controllers\Controller;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\FournisseurRepositoryContract;
use Modules\CrmAutoCar\Models\Brand;
use Modules\DevisAutoCar\Entities\DevisPrice;
use Modules\DevisAutoCar\Entities\DevisTrajetPrice;

class InfomationVogageController extends Controller
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

        $fournisseur_astreinte = '0603315632';

        $fournisseurs = app(FournisseurRepositoryContract::class)->newQuery()
            ->whereHas('devis', function($query) use ($devis) {
                $query->where('id', $devis->id);
            })
            ->get();

//        dd($fournisseurs);

        return view('crmautocar::information-voyage', compact('devis', 'brand', 'price', 'fournisseur_astreinte'));
    }
}
