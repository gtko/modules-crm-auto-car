<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\CoreCRM\Models\Dossier;
use Modules\CrmAutoCar\Contracts\Repositories\ProformatsRepositoryContract;

class ProformatDossier extends Component
{

    public $dossier;
    public $client;
    public $commercial;

    public function mount(ClientEntity $client, Dossier $dossier)
    {
        $this->client = $client;
        $this->dossier = $dossier;


    }


    public function render(ProformatsRepositoryContract $proformatRep)
    {
        $proformats = $proformatRep->newQuery()->whereIn('devis_id', $this->dossier->devis->pluck('id'))->paginate(25);
        $commercials = app(CommercialRepositoryContract::class)->fetchAll();

        return view('crmautocar::livewire.proformat-dossier', compact('proformats', 'commercials'));
    }
}
