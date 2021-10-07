<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\FournisseurRepositoryContract;
use Modules\CrmAutoCar\Mail\RequestFournisseurMail;

class BlockFournisseur extends Component
{
    public $dossier;
    public $fournisseurs;
    public $fournisseur_id;
    public $devi_id;
    public $prix;


    protected $listeners = ['update' => '$refresh'];

    protected $rules = [

        'fournisseur_id' => 'required',
        'devi_id' => 'required',
        'prix' => 'required',

    ];

    public function mount(FournisseurRepositoryContract $repFournisseur, $client, $dossier)
    {
        $this->dossier = $dossier;
        $this->fournisseurs = $repFournisseur->getAllList();

    }

    public function send()
    {
        $this->validate();

        $this->emit('popup-mail:open', ['fournisseur_id' => $this->fournisseur_id, 'devi_id' => $this->devi_id, 'dossier' => $this->dossier, 'prix' => $this->prix]);
    }

    public function validateDemande(int $devisId, int $fournisseurId, FournisseurRepositoryContract $repFournisseur, DevisRepositoryContract $repDevi)
    {
        $deviModel = $repDevi->fetchById($devisId);
        $fournisseurModel = $repFournisseur->fetchById($fournisseurId);

        $repDevi->validateFournisseur($deviModel, $fournisseurModel);

        $this->emit('update');
    }

    public function delete(int $devisId, int $fournisseurId, FournisseurRepositoryContract $repFournisseur, DevisRepositoryContract $repDevi)
    {
        $deviModel = $repDevi->fetchById($devisId);
        $fournisseurModel = $repFournisseur->fetchById($fournisseurId);

        $repDevi->detachFournisseur($deviModel, $fournisseurModel);

        $this->emit('update');
    }

    public function render()
    {
        return view('crmautocar::livewire.block-fournisseur');
    }
}
