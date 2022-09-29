<?php

namespace Modules\CrmAutoCar\Http\Livewire\Dossiers;

use Livewire\Component;

class ListDetail extends Component
{
    public $dossier;
    public $resa = false;

    public function mount($dossier, $resa = false)
    {
        $dossier->load('status', 'commercial.personne', 'followers.personne', 'client.personne', 'tags', 'devis');

        $this->dossier = $dossier;
        $this->resa = $resa;
    }

    public function render()
    {
        return view('crmautocar::livewire.dossiers.list-detail');
    }
}
