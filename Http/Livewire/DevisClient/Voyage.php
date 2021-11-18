<?php

namespace Modules\CrmAutoCar\Http\Livewire\DevisClient;

use Livewire\Component;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CrmAutoCar\Models\Brand;

class Voyage extends Component
{

    public $devis;
    public $brand;
    public $trajet;
    public $trajetId;

    public function mount(DevisEntities $devis, int $trajetId,  Brand $brand){
        $this->devis = $devis;
        $this->brand = $brand;
        $this->trajetId = $trajetId;
        $this->trajet = $this->devis->data['trajets'][$trajetId] ?? null;
    }

    public function render()
    {
        return view('crmautocar::livewire.devis-client.voyage');
    }
}
