<?php

namespace Modules\CrmAutoCar\Entities;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Modules\CrmAutoCar\Contracts\Repositories\DecaissementRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\ProformatsRepositoryContract;
use Modules\CrmAutoCar\Models\Brand;
use Modules\CrmAutoCar\Models\Invoice;
use Modules\CrmAutoCar\Models\Proformat;
use Modules\CrmAutoCar\Models\Traits\EnumStatusDemandeFournisseur;
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


    public function getPriceVenteTTC(){
        return $this->getPriceTTC();
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
        $demandes = $this->proformat->devis->demandeFournisseurs;

       if ($demandes->whereIn('status', EnumStatusDemandeFournisseur::HAS_ACHAT_VALIDE)->count() > 0) {
           return $demandes;
       }

       return false;
    }

    public function getPriceAchat($forceOrigin = false){
        //Si marge modifier on recalcule l'achat
        if($this->margeEdited() && $forceOrigin === false){
            return ($this->getPriceHt() - $this->getDeltaMargeHT()) * (1 + ($this->getTauxTVA() / 100));
        }else {
            $demandes = $this->proformat->devis->demandeFournisseurs;

            if (($demandeValidated=$this->achatValidated())) {
                return $demandeValidated->sum('prix');
            }

            return $demandes->min('prix');
        }
    }

    public function getPriceAchatHT($forceOrigin = false){
        return $this->getPriceAchat($forceOrigin) / (1 + ($this->getTauxTVA() / 100));
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
        $marge = 0;
        $demandes = $this->proformat->devis->demandeFournisseurs;
        if($demandes->count() > 0) {
           $marge =  $this->getPriceHT() - $this->getPriceAchatHT(true);
        }

        return $marge;
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

    public function getDeltaMargeHT()
    {
        return $this->getMargeHT() - $this->getMargeOriginHT();
    }

    public function getSalaireDiff(?Carbon $limit = null){

        return $this->getMargeHT($limit) - $this->getMargeOriginHT();
    }

}
