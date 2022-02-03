<?php

namespace Modules\CrmAutoCar\Http\Livewire\DevisClient;


use Illuminate\Support\Facades\Request;
use Livewire\Component;
use Modules\BaseCore\Contracts\Repositories\AddressRepositoryContract;
use Modules\BaseCore\Contracts\Repositories\PersonneRepositoryContract;
use Modules\BaseCore\Models\Country;
use Modules\CoreCRM\Actions\Devis\GenerateLinkDevis;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Contracts\Repositories\ClientRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Services\FlowCRM;
use Modules\CrmAutoCar\Contracts\Repositories\ProformatsRepositoryContract;
use Modules\CrmAutoCar\Flow\Attributes\ClientDevisExterneValidation;
use Modules\CrmAutoCar\Flow\Attributes\CreateProformatClient;

class PopupValition extends Component
{
    public $devis;
    public $nom;
    public $prenom;
    public $societe;
    public $adresse;
    public $code_zip;
    public $city;
    public $paiementType;
    public $country;

    protected $rules = [
        'nom' => 'required',
        'prenom' => 'required',
        'societe' => 'required',
        'adresse' => 'required',
        'code_zip' => 'required',
        'city' => 'required',
        'country' => 'required',
        'paiementType' => 'required'
    ];


    public function mount(DevisEntities $devis)
    {
        $this->devis = $devis;
    }

    public function render()
    {
        $countries = Country::orderby('name', 'asc')->get();

        return view('crmautocar::livewire.devis-client.popup-valition',
            [
                'countries' => $countries
            ]
        );
    }

    public function store(DevisRepositoryContract $repDevi, ProformatsRepositoryContract $repInvoice)
    {
        $this->validate();

        $data = [
            'paiement_type_validation' => $this->paiementType,
            'nom_validation' => $this->nom,
            'prenom_validation' => $this->prenom,
            'societe_validation' => $this->societe,
            'country_id_validation' => $this->country,
            'address_validation' => $this->adresse,
            'code_zip_validation' => $this->code_zip,
            'city_validation' => $this->city,
            'ip_validation' => Request::ip()
        ];

        $repDevi->validatedDevis($this->devis, $data);
        $personne = app(PersonneRepositoryContract::class)->update($this->devis->dossier->client->personne, $this->nom, $this->prenom, null, 'male');
        $adresse = app(AddressRepositoryContract::class)->update($personne->address, $this->adresse, $this->city, $this->code_zip, $this->country);

        //on créer la proformat
        $total = $this->devis->getTotal();
        $number = $repInvoice->getNextNumber();
        $proformat = $repInvoice->create($this->devis, $total, $number);


        (new FlowCRM())->add($this->devis->dossier, new ClientDevisExterneValidation($this->devis, Request::ip(), $data));
        (new FlowCRM())->add($this->devis->dossier, new CreateProformatClient($proformat));

        session()->flash('success', 'Votre devis a été validé');

        return redirect()->secure((new GenerateLinkDevis())->GenerateLink($this->devis));
    }
}
