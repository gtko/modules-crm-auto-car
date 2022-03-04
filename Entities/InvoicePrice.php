<?php

namespace Modules\CrmAutoCar\Entities;

use Modules\CrmAutoCar\Models\Brand;
use Modules\CrmAutoCar\Models\Invoice;
use Modules\DevisAutoCar\Models\Devi;

class InvoicePrice extends \Modules\CrmAutoCar\Entities\ProformatPrice
{

    protected Invoice $invoice;

    public function __construct(Invoice $invoice, Brand $brand){
        $this->invoice = $invoice;
        parent::__construct($invoice->devis->proformat, $brand);
    }

    public function getAvoirs(){

    }

    public function getTotalAvoirs(){
        return collect($this->invoice->avoirs)->sum('avoir');
    }


}
