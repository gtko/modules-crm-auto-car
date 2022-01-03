<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\CoreCRM\Models\Dossier;

class DossierValidation extends Component
{
    public $dossier;
    public $client;

    public function mount(ClientEntity $client, Dossier $dossier){
        $this->client = $client;
        $this->dossier = $dossier;
    }

    public function render()
    {
        $devis = $this->dossier->devis->filter(function($item){
           return $item['data']['validate'] ?? false;
        });

        return view('crmautocar::livewire.dossier-validation', compact('devis'));
    }
}
