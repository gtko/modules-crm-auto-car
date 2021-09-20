<?php

namespace Modules\CrmAutoCar\Http\Livewire\DevisClient;

use Livewire\Component;

class AccepteDevis extends Component
{
    /**
     * Get the views / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public $accepte = false;
    public $sidebar;
    public $class;



    public function mount($sidebar = false, $class = '')
    {
        $this->class = $class;
        $this->sidebar = $sidebar;
    }

    public function open()
    {
        if($this->accepte)
        {
            $this->emit('isOpen');
        } else {
            $this->addError('accepte', 'Vous devez accepter les CGV pour pouvoir valider votre trajet.');
        }
    }

    public function render()
    {
        return view('crmautocar::livewire.devis-client.accepte-devis');
    }
}
