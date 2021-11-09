<?php

namespace Modules\CrmAutoCar\Http\Livewire\DevisClient;


use Illuminate\Support\Facades\Request;
use Livewire\Component;
use Modules\CoreCRM\Actions\Devis\GenerateLinkDevis;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Services\FlowCRM;
use Modules\CrmAutoCar\Contracts\Repositories\ProformatsRepositoryContract;
use Modules\CrmAutoCar\Flow\Attributes\ClientDevisExterneValidation;
use Modules\CrmAutoCar\Flow\Attributes\CreateProformatClient;

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

    public function store(DevisRepositoryContract $repDevi, ProformatsRepositoryContract $repInvoice)
    {
        $this->validate();

        $data = [
            'paiement_type_validation' => $this->paiementType,
            'name_validation' => $this->name,
            'societe_validation' => $this->societe,
            'address_validation' => $this->adresse,
            'ip_validation' => Request::ip()
        ];
        $repDevi->validatedDevis($this->devis, $data);

        //on créer la proformat
        $total = $this->devis->getTotal();
        $number = $repInvoice->getNextNumber();
        $proformat = $repInvoice->create($this->devis, $total, $number);

        (new FlowCRM())->add($this->devis->dossier, new CreateProformatClient($proformat));
        (new FlowCRM())->add($this->devis->dossier, new ClientDevisExterneValidation($this->devis, Request::ip(), $data));

        session()->flash('success', 'Votre devis a été validé');

        return redirect((new GenerateLinkDevis())->GenerateLink($this->devis));
    }
}
