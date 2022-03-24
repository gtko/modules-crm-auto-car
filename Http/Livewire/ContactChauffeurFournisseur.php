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
            $this->nbrTrajet = count($devis->data['trajets']) ?? null;
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

        $devis = app(DevisRepositoryContract::class)->fetchById($this->devis);
        $fournisseur = app(FournisseurRepositoryContract::class)->fetchById($this->fournisseur);


//        dd($devis);
        $data =
            [
                'type_tajet' => $this->type_trajet,
                'commentaire' => $this->commentaire,
                'sended' => false,

            ];
        app(ContactFournisseurRepositoryContract::class)->create($this->dossier, $fournisseur, $devis, $this->name, $this->phone, $data, $this->trajet);

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
        return app(FournisseurRepositoryContract::class)->newQuery()->whereHas('devis', function ($query) {
            $query->where('dossier_id', $this->dossier->id);
            $query->where('bpa', true);
        })->get();
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
