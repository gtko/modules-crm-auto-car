<?php

namespace Modules\CrmAutoCar\Http\Livewire\DevisClient;

use Livewire\Component;

class PopupValition extends Component
{
    /**
     * Get the views / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public $isOpen = false;

    protected $listeners = ['isOpen' => 'open'];

    public function open()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function render()
    {
        return view('crmautocar::livewire.devis-client.popup-valition');
    }
}
