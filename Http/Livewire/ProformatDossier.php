<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\CoreCRM\Models\Dossier;
use Modules\CrmAutoCar\Contracts\Repositories\ProformatsRepositoryContract;
use Modules\CrmAutoCar\Models\Proformat;

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

    public function save(){
        if(Auth::user()->cannot('changeCommercial', Proformat::class)) {
            abort(403);
        }

    }


    public function render(ProformatsRepositoryContract $proformatRep)
    {
        $proformats = $proformatRep->newQuery()->whereIn('devis_id', $this->dossier->devis->pluck('id'))->paginate(25);


        $commercials = [];
        if(Auth::user()->can('changeCommercial', Proformat::class)) {
            $commercials = app(CommercialRepositoryContract::class)->fetchAll();
        }

        return view('crmautocar::livewire.proformat-dossier', compact('proformats', 'commercials'));
    }
}
