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

        $devis = $this->invoice->devis;
        dd(config('crmautocar.brand_default'));
        $brand = app(BrandsRepository::class)->fetchById(config('crmautocar.brand_default'));
        $devisPrice = new DevisPrice($devis, $brand);

        dd($devisPrice->getPriceTTC(), $devisPrice->getPriceHT(), $devisPrice->getTVA(), $devisPrice->getPriceTVA());

        dd('editer');
    }

    public function avoir(){
        dd("créer un avoir dans la facture");
    }

    public function pdf(){
        dd("Download PDF");
    }

    public function show(){
        dd('Voir la facture proformat');
    }

    public function paiements(){
        dd("Ouvrir la liste des paiements de la factures en modal");
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('crmautocar::livewire.invoices-list-item');
    }
}
