<?php

namespace Modules\CrmAutoCar\Actions;

use Illuminate\Support\Facades\DB;
use Modules\CoreCRM\Contracts\Services\FlowContract;
use Modules\CrmAutoCar\Contracts\Repositories\InvoicesRepositoryContract;
use Modules\CrmAutoCar\Flow\Attributes\CreateInvoiceClient;
use Modules\CrmAutoCar\Models\Invoice;

class CreateInvoice
{


    public function create($devis):Invoice
    {
        $invoiceRep = app(InvoicesRepositoryContract::class);
        DB::beginTransaction();

        $number = $invoiceRep->getNextNumber();
        $invoice = $invoiceRep->create($devis, $devis->getTotal(), $number);

        app(FlowContract::class)->add($devis->dossier, (new CreateInvoiceClient($invoice)));

        DB::commit();

        return $invoice;
    }

}
