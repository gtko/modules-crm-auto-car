<?php

namespace Modules\CrmAutoCar\Http\Livewire\Dossiers;

use Livewire\Component;

class ListDetail extends Component
{
    public $dossier;

    public function mount($dossier)
    {
        $this->dossier = $dossier;
    }

    public function render()
    {
        return view('crmautocar::livewire.dossiers.list-detail');
    }
}
