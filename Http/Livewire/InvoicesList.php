<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CrmAutoCar\Actions\CreateInvoice;
use Modules\CrmAutoCar\Contracts\Repositories\InvoicesRepositoryContract;
use Modules\CrmAutoCar\Models\Invoice;

class InvoicesList extends Component
{

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render(InvoicesRepositoryContract $invoiceRep)
    {

        $query = $invoiceRep->newQuery();

        $query->whereHas('devis', function($query){
            $query->whereHas('proformat');
        });

        $invoiceRep->setQuery($query);

        return view('crmautocar::livewire.invoices-list', [
            'invoices' => $invoiceRep->fetchAll(100)
        ]);
    }
}
