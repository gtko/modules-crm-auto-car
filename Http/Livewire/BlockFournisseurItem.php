<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Services\FlowCRM;
use Modules\CrmAutoCar\Contracts\Repositories\DevisAutocarRepositoryContract;
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierDemandeFournisseurDelete;
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierDemandeFournisseurValidate;
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierFournisseurBpa;
use Modules\CrmAutoCar\Models\Fournisseur;
use Modules\DevisAutoCar\Models\Devi;

class BlockFournisseurItem extends Component
{
    public $fourni;
    public $devi;
    public $price = null;
    public $editPrice = false;
    public $bpa = false;

    protected $listeners = ['update' => '$refresh'];

    protected $rules = [
        'fournisseur_id' => 'required',
        'devi_id' => 'required',

    ];

    public function mount(Fournisseur $fournisseur, Devi $devis) {

        $this->devi = $devis;
        $this->fourni = $this->devi->fournisseurs->where('id', $fournisseur->id)->first();
        $this->price = $this->fourni->pivot->price ?? null;
        $this->bpa = $this->fourni->pivot->bpa ?? false;
    }

    public function editerPrice(){
        $this->editPrice = true;
    }

    public function closePrice(){
        $this->editPrice = false;
    }

    public function bpa(DevisAutocarRepositoryContract $repDevi)
    {
        if($this->price != null)
            $repDevi->bpaFournisseur($this->devi, $this->fourni);
            (new FlowCRM())->add($this->devi->dossier , new ClientDossierFournisseurBpa(Auth::user(), $this->devi, $this->fourni));

        $this->emit('update');
    }

    public function savePrice(DevisRepositoryContract $repDevi) {
        if($this->price != null)
        {
            $repDevi->savePriceFournisseur($this->devi, $this->fourni, $this->price);
        }
        $this->closePrice();
    }

    public function validateDemande(DevisRepositoryContract $repDevi)
    {
        if($this->price != null)
            $repDevi->validateFournisseur($this->devi, $this->fourni);
            $prix = $repDevi->getPrice($this->devi, $this->fourni);
            (new FlowCRM())->add($this->devi->dossier , new ClientDossierDemandeFournisseurValidate(Auth::user(), $this->devi, $this->fourni, $prix));

            $this->emit('update');
    }

    public function delete(DevisRepositoryContract $repDevi)
    {
        $repDevi->detachFournisseur($this->devi, $this->fourni);
        (new FlowCRM())->add($this->devi->dossier , new ClientDossierDemandeFournisseurDelete(Auth::user(), $this->devi, $this->fourni));

        $this->emit('update');
    }

    public function render()
    {
        $this->fourni = $this->devi->fournisseurs->where('id', $this->fourni->id)->first();
        return view('crmautocar::livewire.block-fournisseur-item');
    }
}