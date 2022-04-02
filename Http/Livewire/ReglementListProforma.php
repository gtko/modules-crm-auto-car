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

        $plus45j = false;
        if($this->proforma->devis->date_depart) {
            $plus45j = $this->proforma->created_at->diffInDays($this->proforma->devis->date_depart) > 45;
        }



        return view('crmautocar::livewire.reglement-list-proforma', compact('paiements', 'plus45j'));
    }
}
