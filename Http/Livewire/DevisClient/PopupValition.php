<?php

namespace Modules\CrmAutoCar\Http\Livewire\DevisClient;

use Livewire\Component;
use Modules\BaseCore\Http\Livewire\AbstractModal;
use Modules\CoreCRM\Services\FlowCRM;
use Modules\CrmAutoCar\Flow\Attributes\ClientDevisExterneConsultation;

class PopupValition extends Component
{
//    protected $rules = [
//
//    ];

    public function mount($devis)
    {
        dd($devis);
    }

    public function render()
    {
        return view('crmautocar::livewire.devis-client.popup-valition');
    }

    public function store()
    {
//        $this->validate();

//        (new FlowCRM())->add($devis->dossier , new ClientDevisExterneConsultation($devis, Request::ip()));
    }
}
