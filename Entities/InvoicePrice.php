<?php

namespace Modules\CrmAutoCar\Entities;

use Modules\CrmAutoCar\Models\Brand;
use Modules\CrmAutoCar\Models\Invoice;
use Modules\DevisAutoCar\Models\Devi;

class InvoicePrice extends \Modules\DevisAutoCar\Entities\DevisPrice
{

    protected Invoice $invoice;

    public function __construct(Invoice $invoice, Brand $brand){
        $this->invoice = $invoice;
        parent::__construct($invoice->devis, $brand);
    }


    public function paid(){
        return  $this->invoice->payments->sum('total');
    }

    public function remains(){
        return $this->getPriceTTC() - $this->paid();
    }


}
