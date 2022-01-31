<?php

namespace Modules\CrmAutoCar\Entities;

use Illuminate\Support\Facades\Cache;
use Modules\CrmAutoCar\Contracts\Repositories\DecaissementRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\ProformatsRepositoryContract;
use Modules\CrmAutoCar\Models\Brand;
use Modules\CrmAutoCar\Models\Invoice;
use Modules\CrmAutoCar\Models\Proformat;
use Modules\DevisAutoCar\Models\Devi;

class ProformatPrice extends \Modules\DevisAutoCar\Entities\DevisPrice
{

    public ProformatsRepositoryContract $repository;
    public Proformat $proformat;

    public function __construct(Proformat $proformat, Brand $brand){
        parent::__construct($proformat->devis, $brand);
        $this->proformat = $proformat;
        $this->repository = app(ProformatsRepositoryContract::class);
    }


    public function getPriceVente(){
        return $this->getPriceHT();
    }

    protected function cachedDecaissement(){
        return Cache::remember('decaissement_proformat_'.$this->proformat->devis->dossier->id,60, function(){
            return app(DecaissementRepositoryContract::class)->getByDossier($this->proformat->devis->dossier);
        });
    }

    public function achatValidated(){
       $fournisseurs = $this->proformat->devis->fournisseurs;

       if($fournisseurs->where('pivot.bpa', true)->count() > 0) {
           return true;
       }

       return false;
    }

    public function getPriceAchat(){
        $fournisseurs = $this->proformat->devis->fournisseurs;

        if($fournisseurs->where('pivot.bpa', true)->count() > 0) {
            return $fournisseurs->where('pivot.bpa', true)->sum('pivot.prix');
        }

        return $fournisseurs->where('pivot.prix', '>', 0)->min('pivot.prix');
    }

    public function paid(){
        return $this->proformat->payments->sum('total') ?? 0;
    }

    public function remains(){
        return $this->getPriceTTC() - $this->paid();
    }

    public function getMargeOriginHT()
    {
        return $this->getPriceVente() - $this->getPriceAchat();
    }

    public function getMargeHT()
    {
        if($this->repository->hasMargeEdited($this->proformat)){
            return $this->repository->getLastMarge($this->proformat);
        }
        return  $this->getMargeOriginHT();
    }

}
