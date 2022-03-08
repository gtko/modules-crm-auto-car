<?php

namespace Modules\CrmAutoCar\Http\Livewire\DevisClient;

use Livewire\Component;
use Modules\DevisAutoCar\Entities\DevisPrice;
use Modules\DevisAutoCar\Entities\DevisTrajetPrice;

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

    public $devis;
    public $brand;

    public $trajetid;
    public $trajet;

    public $proformat;

    public function mount($devis, $brand, $trajetId = null, $sidebar = false, $printable = false, $class = '', $proformat = null)
    {
        $this->sidebar = $sidebar;
        $this->class = $class;
        $this->devis = $devis;
        $this->printable = $printable;
        $this->brand = $brand;
        $this->trajetid = $trajetId;
        $this->trajet = $this->devis->data['trajets'][$this->trajetid] ?? null;
        $this->proformat = $proformat;
    }


    public function render()
    {
        if ($this->trajet) {
            $price = (new DevisTrajetPrice($this->devis, $this->trajetid, $this->brand));
        } else {
            $price = (new DevisPrice($this->devis, $this->brand));
        }
        return view('crmautocar::livewire.devis-client.recap-devis', compact('price'));
    }
}
