<?php

namespace Modules\CrmAutoCar\Http\Livewire\DevisClient;

use Livewire\Component;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CrmAutoCar\Models\Brand;

class Voyage extends Component
{

    public $devis;
    public $brand;

    public function mount(DevisEntities $devis, Brand $brand){
        $this->devis = $devis;
        $this->brand = $brand;
    }

    public function render()
    {
        return view('crmautocar::livewire.devis-client.voyage');
    }
}
