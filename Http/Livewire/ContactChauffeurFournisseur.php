<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\FournisseurRepositoryContract;
use Modules\CoreCRM\Models\Dossier;
use Modules\CrmAutoCar\Contracts\Repositories\ContactFournisseurRepositoryContract;

class ContactChauffeurFournisseur extends Component
{
    public $dossier;
    public $client;
    public $fournisseur_id;
    public $devis_id;
    public $type_trajet;

    public $name;
    public $phone;

    protected $rules = [
        'name' => 'required',
        'phone' => 'required',
    ];

    protected $listeners = [
        'contactchauffeurfournisseur::refresh' => '$refresh',
    ];

    public function mount(ClientEntity $client, Dossier $dossier)
    {
        $this->client = $client;
        $this->dossier = $dossier;
    }

    /**
     * Store the contact
     *
     * @return void
     */
    public function store()
    {
        $this->validate();

        $fournisseur = app(FournisseurRepositoryContract::class)->fetchById($this->fournisseur_id);

        app(ContactFournisseurRepositoryContract::class)->create($this->dossier, $fournisseur, $this->name, $this->phone);

        $this->reset([
            'name',
            'phone',
        ]);
    }

    /***
     * @return \Illuminate\Database\Eloquent\Collection|\Modules\CrmAutoCar\Models\Fournisseur[]
     */
    public function getFournisseurs(){
        return app(FournisseurRepositoryContract::class)->all();
    }

    public function render()
    {
        $contacts = app(ContactFournisseurRepositoryContract::class)->getByDossier($this->dossier);

        return view('crmautocar::livewire.contact-chauffeur-fournisseur', [
            'fournisseurs' => $this->getFournisseurs(),
            'contacts' => $contacts
        ]);
    }
}
