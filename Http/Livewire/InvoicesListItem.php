<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
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
        dd('editer');
    }

    public function avoir(){
        $this->emit('avoir_'.$this->invoice->id.':open', ['invoice' => $this->invoice]);
    }

    public function pdf(){
        dd("Download PDF");
    }

    public function show(){
        dd('Voir la facture proformat');
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $devis = $this->invoice->devis;
        $brand = app(BrandsRepository::class)->fetchById(config('crmautocar.brand_default'));

        return view('crmautocar::livewire.invoices-list-item', [
            'price' => new DevisPrice($devis, $brand)
        ]);
    }
}
