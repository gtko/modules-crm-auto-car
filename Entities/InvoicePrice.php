<?php

namespace Modules\CrmAutoCar\Entities;

use Modules\CrmAutoCar\Models\Brand;
use Modules\CrmAutoCar\Models\Invoice;
use Modules\DevisAutoCar\Models\Devi;

class InvoicePrice extends \Modules\DevisAutoCar\Entities\DevisPrice
{

    public function __construct(Invoice $invoice, Brand $brand){
        parent::__construct($invoice->devis, $brand);
    }



}
