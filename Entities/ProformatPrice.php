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

    public function paid(){
        return $this->proformat->payments->sum('total') ?? 0;
    }

    public function remains(){
        return $this->getPriceTTC() - $this->paid();
    }


    public function getMargeHT()
    {
        return $this->getPriceVente() - $this->getPriceAchat();
    }

}
