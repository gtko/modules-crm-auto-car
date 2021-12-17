<?php

namespace Modules\CrmAutoCar\Entities;

use Modules\CrmAutoCar\Contracts\Repositories\DecaissementRepositoryContract;
use Modules\CrmAutoCar\Models\Brand;
use Modules\CrmAutoCar\Models\Invoice;
use Modules\CrmAutoCar\Models\Proformat;
use Modules\DevisAutoCar\Models\Devi;

class ProformatPrice extends \Modules\DevisAutoCar\Entities\DevisPrice
{

    public Proformat $proformat;

    public function __construct(Proformat $proformat, Brand $brand){
        parent::__construct($proformat->devis, $brand);
        $this->proformat = $proformat;
    }


    public function getPriceVente(){
        return $this->getPriceHT();
    }

    public function getPriceAchat(){
        $price = 0;
        $decaissement = app(DecaissementRepositoryContract::class)->getByDossier($this->proformat->devis->dossier);
        return $decaissement->sum('payer') + ($decaissement->last()->restant ?? 0);
    }

    public function getTotalPayment(){
        $devis = $this->proformat->devis;

        if($devis->invoice){
            return (new InvoicePrice($devis->invoice, $this->brand))->paid();
        }

        return 0;
    }

    public function getRestant(){
        return $this->getPriceTTC() - $this->getTotalPayment();
    }


    public function getMargeHT()
    {
        return $this->getPriceVente() - $this->getPriceAchat();
    }

}
