<?php

namespace Modules\CrmAutoCar\Http\Livewire\DevisClient;

use Livewire\Component;
use Modules\DevisAutoCar\Entities\DevisPrice;

class RecapDevis extends Component
{
    /**
     * Get the views / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public $sidebar;
    public $class;
    public $accepte = false;

    public  $devis;
    public  $brand;

    public function mount($devis, $brand,  $sidebar = false, $class = '', )
    {
        $this->sidebar = $sidebar;
        $this->class = $class;
        $this->devis = $devis;
        $this->brand = $brand;
    }


    public function render()
    {
        $price = (new DevisPrice($this->devis, $this->brand));
        return view('crmautocar::livewire.devis-client.recap-devis', compact('price'));
    }
}
