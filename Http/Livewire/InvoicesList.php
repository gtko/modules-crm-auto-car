<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CrmAutoCar\Contracts\Repositories\InvoicesRepositoryContract;
use Modules\CrmAutoCar\Models\Invoice;

class InvoicesList extends Component
{


    public function create(InvoicesRepositoryContract $invoiceRep, DevisEntities $devis){

        dd($devis->data);

        DB::beginTransaction();

        $number = $invoiceRep->getNextNumber();
        $invoiceRep->create($devis, $devis->getTotal(), $number);

        DB::commit();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('crmautocar::livewire.invoices-list', [
            'invoices' => Invoice::all()
        ]);
    }
}
