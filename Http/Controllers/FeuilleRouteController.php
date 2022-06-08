<?php

namespace Modules\CrmAutoCar\Http\Controllers;

use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\FournisseurRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\ContactFournisseurRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\DemandeFournisseurRepositoryContract;
use Modules\CrmAutoCar\Models\Brand;
use Modules\DevisAutoCar\Entities\DevisPrice;
use Modules\DevisAutoCar\Entities\DevisTrajetPrice;

class FeuilleRouteController
{
    public function index($devisId, DevisRepositoryContract $devisRep,)
    {
        $devis = $devisRep->fetchById($devisId);
        $brand = Brand::first();
        $trajetid = 0;
        $trajet = $devis->data['trajets'][$trajetid] ?? null;

        if($trajet){
            $price = (new DevisTrajetPrice($devis, $trajetid, $brand));
        }else {
            $price = (new DevisPrice($devis, $brand));
        }


        $fournisseurs = app(DemandeFournisseurRepositoryContract::class)->getDemandeByDevis($devis);

        $fournisseur_astreinte = $fournisseurs->first()->astreinte;

        $chauffeurs = app(ContactFournisseurRepositoryContract::class)->newQuery()
            ->whereIn('fournisseur_id',  $fournisseurs->pluck('user_id'))
            ->where('devi_id', $devis->id)
            ->get();



        return view('crmautocar::feuille-route', compact('devis', 'brand', 'price', 'fournisseur_astreinte', 'chauffeurs'));
    }
}
