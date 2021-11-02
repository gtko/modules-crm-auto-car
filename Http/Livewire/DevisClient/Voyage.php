<?php

namespace Modules\CrmAutoCar\Http\Livewire\DevisClient;

use Livewire\Component;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;

class Voyage extends Component
{

    public $devis;

    public function mount(DevisEntities $devis){
        $this->devis = $devis;
    }

    public function render()
    {
        return view('crmautocar::livewire.devis-client.voyage');
    }
}
