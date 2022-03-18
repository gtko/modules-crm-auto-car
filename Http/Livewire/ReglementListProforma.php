<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\CrmAutoCar\Models\Proformat;

class ReglementListProforma extends Component
{
    public $proforma;

    public function mount(Proformat $proforma){
        $this->proforma = $proforma;
    }

    public function render()
    {
        $paiements = $this->proforma->payments;
        return view('crmautocar::livewire.reglement-list-proforma', compact('paiements'));
    }
}
