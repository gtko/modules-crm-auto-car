<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\CoreCRM\Models\Dossier;
use Modules\CrmAutoCar\Contracts\Repositories\ProformatsRepositoryContract;

class ProformatDossier extends Component
{

    public $dossier;
    public $client;

    public function mount(ClientEntity $client, Dossier $dossier){
        $this->client = $client;
        $this->dossier = $dossier;
    }


    public function render(ProformatsRepositoryContract $proformatRep)
    {
        $proformats = $proformatRep->newQuery()->whereIn('devis_id', $this->dossier->devis->pluck('id'))->paginate(25);

        return view('crmautocar::livewire.proformat-dossier', compact('proformats'));
    }
}
