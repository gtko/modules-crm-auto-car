<?php

namespace Modules\CrmAutoCar\Http\Livewire\DevisClient;


use Illuminate\Support\Facades\Request;
use Livewire\Component;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Services\FlowCRM;
use Modules\CrmAutoCar\Flow\Attributes\ClientDevisExterneValidation;

class PopupValition extends Component
{
    public $devis;
    public $name;
    public $societe;
    public $adresse;

    protected $rules = [
        'name' => '',
        'societe' => '',
        'adresse' => '',
    ];


    public function mount(DevisEntities $devis)
    {

    }

    public function render()
    {
        return view('crmautocar::livewire.devis-client.popup-valition');
    }

    public function store()
    {
        $this->validate();
        dd($this->devi->dossier, $this->devi, Request::ip())
        (new FlowCRM())->add($this->devi->dossier, new ClientDevisExterneValidation($this->devi, Request::ip()));
        dd('devis validé');
    }
}
