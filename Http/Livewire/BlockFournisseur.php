<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\FournisseurRepositoryContract;
use Modules\CoreCRM\Services\FlowCRM;
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierDemandeFournisseurDelete;
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierDemandeFournisseurValidate;


class BlockFournisseur extends Component
{
    public $dossier;
    public $fournisseurs;
    public $fournisseur_id;
    public $devi_id;
    public $price = null;


    protected $listeners = ['update' => '$refresh'];

    protected $rules = [

        'fournisseur_id' => 'required',
        'devi_id' => 'required',

    ];

    public function mount(FournisseurRepositoryContract $repFournisseur, $client, $dossier)
    {
        $this->dossier = $dossier;
        $this->fournisseurs = $repFournisseur->getAllList();

        foreach ($dossier->devis as $devi)
        {
            foreach ($devi->fournisseurs as $fourni)
            {
                $this->price[$fourni->id] = $fourni->pivot->prix;
            }
        }

    }

    public function send()
    {
        $this->validate();

        $this->emit('popup-mail:open', ['fournisseur_id' => $this->fournisseur_id, 'devi_id' => $this->devi_id, 'dossier' => $this->dossier]);
    }

    public function savePrice(DevisRepositoryContract $repDevi, FournisseurRepositoryContract $repFournisseur, int $devisId, int $fournisseurId) {


        if($this->price != null)
        {
            $devi = $repDevi->fetchById($devisId);
            $fournisseur = $repFournisseur->fetchById($fournisseurId);

            $repDevi->savePriceFournisseur($devi, $fournisseur, $this->price[$fournisseurId]);
        }
    }

    public function validateDemande(int $devisId, int $fournisseurId, FournisseurRepositoryContract $repFournisseur, DevisRepositoryContract $repDevi)
    {
        if($this->price != null)
        $deviModel = $repDevi->fetchById($devisId);
        $fournisseurModel = $repFournisseur->fetchById($fournisseurId);


        $repDevi->validateFournisseur($deviModel, $fournisseurModel);
        $prix = $repDevi->getPrice($deviModel, $fournisseurModel);

        (new FlowCRM())->add($this->dossier , new ClientDossierDemandeFournisseurValidate(Auth::user(), $deviModel, $fournisseurModel, $prix));

        $this->emit('update');
    }

    public function delete(int $devisId, int $fournisseurId, FournisseurRepositoryContract $repFournisseur, DevisRepositoryContract $repDevi)
    {
        $deviModel = $repDevi->fetchById($devisId);
        $fournisseurModel = $repFournisseur->fetchById($fournisseurId);

        $prix = $repDevi->getPrice($deviModel, $fournisseurModel);


        $repDevi->detachFournisseur($deviModel, $fournisseurModel);
        (new FlowCRM())->add($this->dossier , new ClientDossierDemandeFournisseurDelete(Auth::user(), $deviModel, $fournisseurModel));

        $this->emit('update');
    }

    public function render()
    {
        return view('crmautocar::livewire.block-fournisseur');
    }
}
