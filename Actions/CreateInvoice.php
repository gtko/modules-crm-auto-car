<?php

namespace Modules\CrmAutoCar\Actions;

use Illuminate\Support\Facades\DB;
use Modules\CrmAutoCar\Contracts\Repositories\InvoicesRepositoryContract;
use Modules\CrmAutoCar\Models\Invoice;

class CreateInvoice
{


    public function create($devis):Invoice
    {
        $invoiceRep = app(InvoicesRepositoryContract::class);
        DB::beginTransaction();

        $number = $invoiceRep->getNextNumber();
        $invoice = $invoiceRep->create($devis, $devis->getTotal(), $number);

        DB::commit();

        return $invoice;
    }

}
