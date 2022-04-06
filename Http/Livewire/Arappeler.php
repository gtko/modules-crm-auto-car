<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\CoreCRM\Contracts\Services\FlowContract;
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierRappeler;

class Arappeler extends Component
{

    public $dossier;

    public function mount($client, $dossier){
        $this->dossier = $dossier;
    }

    public function rappeler(){

        app(FlowContract::class)
            ->add($this->dossier, new ClientDossierRappeler($this->dossier, $this->dossier->commercial, Auth::user()));

        return redirect()->route('dossiers.show', [$this->dossier->client, $this->dossier]);
    }

    public function render()
    {
        return view('crmautocar::livewire.arappeler');
    }
}
