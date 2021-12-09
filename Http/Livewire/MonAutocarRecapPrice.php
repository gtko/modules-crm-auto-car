<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\DevisAutoCar\Entities\DevisPrice;
use Modules\DevisAutoCar\Entities\DevisTrajetPrice;

class MonAutocarRecapPrice extends Component
{
    public $accepte = false;

    public  $devis;
    public  $brand;

    public  $trajetid;
    public  $trajet;

    public function mount($devis, $brand, $trajetId = null)
    {
        $this->devis = $devis;
        $this->brand = $brand;
        $this->trajetid = $trajetId;
        $this->trajet = $this->devis->data['trajets'][$this->trajetid] ?? null;
    }

    public function render()
    {
        if($this->trajet){
            $price = (new DevisTrajetPrice($this->devis, $this->trajetid, $this->brand));
        }else {
            $price = (new DevisPrice($this->devis, $this->brand));
        }
        return view('crmautocar::livewire.mon-autocar-recap-price' ,compact('price'));
    }
}
