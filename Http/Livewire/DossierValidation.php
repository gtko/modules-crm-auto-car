<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\CoreCRM\Models\Dossier;

class DossierValidation extends Component
{
    public $dossier;
    public $client;
    public $devis;

    protected $listeners =
        [
          'refreshStatusDevis' => '$refresh'
        ];


    public function mount(ClientEntity $client, Dossier $dossier){
        $this->client = $client;
        $this->dossier = $dossier;
    }

    public function openPopup($devi_id)
    {
        $this->emit('popup-validation-devis:open',['devi_id' => $devi_id]);
    }

    public function render()
    {
        $this->devis = $this->dossier->devis->filter(function($item){
           return $item['data']['validate'] ?? false;
        });

        return view('crmautocar::livewire.dossier-validation');
    }
}
