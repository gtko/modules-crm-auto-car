<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\FournisseurRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\TagFournisseurRepositoryContract;
use Modules\CoreCRM\Flow\Attributes\ClientDossierNoteCreate;
use Modules\CoreCRM\Models\Dossier;
use Modules\CoreCRM\Services\FlowCRM;
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierDemandeFournisseurSend;
use Modules\CrmAutoCar\Flow\Attributes\SendInformationVoyageMailFournisseur;

class DossierValidation extends Component
{
    public $dossier;
    public $client;

    public $devis;

    public function mount(ClientEntity $client, Dossier $dossier){
        $this->client = $client;
        $this->dossier = $dossier;
    }

    public function getListeners()
    {
        return [
            'refreshStatusDevis' => '$refresh',
        ];
    }

    public function render()
    {
        $this->devis = $this->dossier->devis->filter(function($item){
           return $item['data']['validate'] ?? false;
        });

        return view('crmautocar::livewire.dossier-validation');
    }
}
