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
        $this->devis = $devis;
    }

    public function render()
    {
        return view('crmautocar::livewire.devis-client.popup-valition');
    }

    public function store()
    {
        $this->validate();
        (new FlowCRM())->add($this->devis->dossier, new ClientDevisExterneValidation($this->devis, Request::ip()));
        dd('devis validé');
    }
}
