<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\CoreCRM\Models\Dossier;

class ElementListCuve extends Component
{
    public $dossier;
    public $selection = false;


    public function updatedSelection()
    {
        $this->emit('dossierSelected', $this->selection);
    }

    public function mount(Dossier $dossier)
    {
        $this->dossier = $dossier;
    }

    public function render()
    {
        return view('crmautocar::livewire.element-list-cuve');
    }
}
