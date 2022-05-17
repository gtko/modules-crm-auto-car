<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\FournisseurRepositoryContract;
use Modules\CoreCRM\Models\Dossier;
use Modules\CrmAutoCar\Contracts\Repositories\ContactFournisseurRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\DemandeFournisseurRepositoryContract;
use Modules\CrmAutoCar\Models\Traits\EnumStatusDemandeFournisseur;

class ContactChauffeurFournisseur extends Component
{
    public $dossier;
    public $client;
    public $demandeSelect;
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

    public function updatedDemandeSelect()
    {
        if ($this->demandeSelect) {
            $demande = app(DemandeFournisseurRepositoryContract::class)->fetchById($this->demandeSelect);
            $this->nbrTrajet = count($demande->devis->data['trajets']) ?? null;
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

        $demande = app(DemandeFournisseurRepositoryContract::class)->fetchById($this->demandeSelect);

        $data =
            [
                'type_tajet' => $this->type_trajet,
                'commentaire' => $this->commentaire,
                'sended' => false,

            ];
        app(ContactFournisseurRepositoryContract::class)->create($this->dossier, $demande->fournisseur, $demande->devis, $this->name, $this->phone, $data, $this->trajet);

        $this->reset([
            'name',
            'phone',
            'commentaire',
            'trajet',
            'type_trajet',
        ]);
    }

    /***
     * @return \Illuminate\Database\Eloquent\Collection|\Modules\CrmAutoCar\Models\Fournisseur[]
     */
    public function getDemandeFournisseur()
    {
        return app(DemandeFournisseurRepositoryContract::class)
            ->newQuery()->whereHas('devis', function ($query) {
                $query->where('dossier_id', $this->dossier->id);
            })
            ->where('status', EnumStatusDemandeFournisseur::STATUS_BPA)
            ->get();
    }

    public function render()
    {
        $contacts = app(ContactFournisseurRepositoryContract::class)->getByDossier($this->dossier);

        return view('crmautocar::livewire.contact-chauffeur-fournisseur', [
            'demandeFournisseur' => $this->getDemandeFournisseur(),
            'contacts' => $contacts
        ]);
    }
}
