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


    public function paid(){
        return  $this->invoice->devis->proformat->payments->sum('total') ?? 0;
    }

    public function remains(){
        return $this->getPriceTTC() - $this->paid();
    }


}
