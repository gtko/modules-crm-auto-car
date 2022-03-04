<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\BaseCore\Actions\Url\SigneRoute;
use Modules\CrmAutoCar\Contracts\Repositories\BrandsRepositoryContract;
use Modules\CrmAutoCar\Entities\InvoicePrice;
use Modules\CrmAutoCar\Models\Invoice;
use Modules\CrmAutoCar\Repositories\BrandsRepository;
use Modules\DevisAutoCar\Entities\DevisPrice;

class InvoicesListItem extends Component
{

    public $invoice;

    public function mount(Invoice $invoice){
        $this->invoice = $invoice;
    }

    public function editer(){
        $dossier = $this->invoice->devis->dossier;
       return redirect()->route('dossiers.show', [$dossier->client, $dossier, 'tab' => 'invoices']);
    }

    public function avoir(){
        $this->emit('avoir_'.$this->invoice->id.':open', ['invoice' => $this->invoice]);
    }

    public function pdf(){
        return redirect((new SigneRoute())->signer('invoices.pdf', [$this->invoice->id]));
    }

    public function show(){
        return redirect((new SigneRoute())->signer('invoices.show', [$this->invoice->id]));
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('crmautocar::livewire.invoices-list-item', [
            'price' => new InvoicePrice($this->invoice, app(BrandsRepositoryContract::class)->getDefault())
        ]);
    }
}
