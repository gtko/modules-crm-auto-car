<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\CrmAutoCar\Models\Dossier;
use Modules\CrmAutoCar\Models\Proformat;

class CalculeMarge extends Component
{
    public $client;
    public $dossier_id;

    public function mount($client,$dossier)
    {
        $this->client = $client;
        $this->dossier_id = $dossier->id;
    }

    public function render()
    {
        $proformats = Proformat::whereHas('devis', function($query){
            $query->where('dossier_id',$this->dossier_id);
        })->get();


        return view('crmautocar::livewire.calcule-marge', compact('proformats'));
    }
}
