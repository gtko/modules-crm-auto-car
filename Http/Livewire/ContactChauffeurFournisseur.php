<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\FournisseurRepositoryContract;
use Modules\CoreCRM\Models\Dossier;
use Modules\CrmAutoCar\Contracts\Repositories\ContactFournisseurRepositoryContract;

class ContactChauffeurFournisseur extends Component
{
    public $dossier;
    public $client;
    public $fournisseur;
    public $devis;
    public $type_trajet;
    public $trajet;
    public $nbrTrajet;
    public $commentaire;

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

    public function updatedDevis()
    {
        if ($this->devis) {
            $devis = app(DevisRepositoryContract::class)->fetchById($this->devis);
            $this->nbrTrajet = count($devis->data['trajets']) ?? 0;
        }

    }

    /**
     * Store the contact
     *
     * @return void
     */
    public function store()
    {
        $this->validate();

        $fournisseur = app(FournisseurRepositoryContract::class)->fetchById($this->fournisseur);

        $data =
            [
                'type_tajet' => $this->type_trajet,
                'number_trajet' => $this->trajet,
                'commentaire' => $this->commentaire,

            ];


        app(ContactFournisseurRepositoryContract::class)->create($this->dossier, $fournisseur, $this->name, $this->phone, $data);

        $this->reset([
            'name',
            'phone',
            'commentaire',
            'trajet',
            'type_trajet',
            'devis',
            'fournisseur',
        ]);
    }

    /***
     * @return \Illuminate\Database\Eloquent\Collection|\Modules\CrmAutoCar\Models\Fournisseur[]
     */
    public function getFournisseurs()
    {
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
