<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\InvoicesRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\ProformatsRepositoryContract;
use Modules\CrmAutoCar\Models\Invoice;

class InvoiceCancel extends Component
{
    public $invoice;

    public function mount(Invoice $invoice){
        $this->invoice = $invoice;
    }

    public function invoiceCancel(InvoicesRepositoryContract $invoiceRep){
        $invoiceRep->cancel($this->invoice);
        $this->emit('invoiceCanceled');
    }

    public function render()
    {
        return view('crmautocar::livewire.invoice-cancel');
    }
}
