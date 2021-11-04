<?php

namespace Modules\CrmAutoCar\Http\Livewire\DevisClient;


use Illuminate\Support\Facades\Request;
use Livewire\Component;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Services\FlowCRM;
use Modules\CrmAutoCar\Flow\Attributes\ClientDevisExterneValidation;

class PopupValition extends Component
{
    public $devis;
    public $name;
    public $societe;
    public $adresse;
    public $paiementType;

    protected $rules = [
        'name' => 'required',
        'societe' => 'required',
        'adresse' => 'required',
        'paiementType' => 'required'
    ];


    public function mount(DevisEntities $devis)
    {
        $this->devis = $devis;
    }

    public function render()
    {
        return view('crmautocar::livewire.devis-client.popup-valition');
    }

    public function store(DevisRepositoryContract $repDevi)
    {
        $this->validate();

        $data = [
            'paiement_type_validation' => $this->paiementType,
            'name_validation' => $this->name,
            'societe_validation' => $this->societe,
            'address_validation' => $this->adresse,

        ];
        $repDevi->validatedDevis($this->devis, $data);

        (new FlowCRM())->add($this->devis->dossier, new ClientDevisExterneValidation($this->devis, Request::ip(), $data));
//

    }
}
