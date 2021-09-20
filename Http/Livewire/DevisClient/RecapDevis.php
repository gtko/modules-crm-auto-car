<?php

namespace Modules\CrmAutoCar\Http\Livewire\DevisClient;

use Livewire\Component;

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

    public function mount($devis, $sidebar = false, $class = '', )
    {
        $this->sidebar = $sidebar;
        $this->class = $class;
    }


    public function render()
    {
        return view('crmautocar::livewire.devis-client.recap-devis');
    }
}
