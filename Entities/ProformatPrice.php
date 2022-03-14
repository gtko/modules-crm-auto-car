<?php

namespace Modules\CrmAutoCar\Entities;

use Carbon\Carbon;
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
        //Si marge modifier on recalcule l'achat
        if($this->margeEdited()){
            return $this->getPriceHt() - $this->getMargeHT();
        }else {
            $fournisseurs = $this->proformat->devis->fournisseurs;

            if ($fournisseurs->where('pivot.bpa', true)->count() > 0) {
                return $fournisseurs->where('pivot.bpa', true)->sum('pivot.prix');
            }

            return $fournisseurs->where('pivot.prix', '>', 0)->min('pivot.prix');
        }
    }

    public function paid(){
        return $this->proformat->payments->sum('total') ?? 0;
    }

    public function remains(){
        $devis = $this->proformat->devis;
        if($devis && $devis->invoice && $devis->invoice->hasCanceled()){
            return 0;
        }

        if(!$this->hasOverPaid()) {
            return $this->getPriceTTC() - $this->paid();
        }

        return 0;
    }

    public function hasOverPaid(){
        return $this->paid() > 0 && $this->getPriceTTC() < $this->paid();
    }

    public function overPaid(){
        if($this->getPriceTTC() > 0) {
            return $this->paid() - $this->getPriceTTC();
        }

        return $this->paid();
    }

    public function hasRefund(){
        return $this->paid() === 0.0 && $this->proformat->payments->count() > 0 && $this->getPriceTTC() < 0;
    }

    public function getMargeOriginHT()
    {
        $fournisseurs = $this->proformat->devis->fournisseurs;
        if($fournisseurs->count() > 0) {
            return $this->getPriceVente() - $this->getPriceAchat();
        }

        return 0;
    }

    public function getMargeHT(?Carbon $limit = null)
    {
        if($this->repository->hasMargeEdited($this->proformat)){
            return $this->repository->getLastMarge($this->proformat, $limit);
        }
        return  $this->getMargeOriginHT();
    }

    public function margeEdited(){
        return $this->repository->hasMargeEdited($this->proformat);
    }

    public function getSalaireDiff(?Carbon $limit = null){
        return $this->getMargeHT($limit) - $this->getMargeOriginHT();
    }

}
