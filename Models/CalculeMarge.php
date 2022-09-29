<?php

namespace Modules\CrmAutoCar\Models;

use Livewire\Component;
use Modules\CrmAutoCar\Contracts\Entities\ClientEntity;

class CalculeMarge extends Component
{
    public $client;
    public $dossier;

    public function mount(ClientEntity $client, Dossier $dossier)
    {
        $this->client = $client;
        $this->dossier = $dossier;
    }

    public function render()
    {
        return view('crmautocar::livewire.calcule-marge');
    }
}
