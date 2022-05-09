<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\FournisseurRepositoryContract;
use Modules\CoreCRM\Services\FlowCRM;
use Modules\CrmAutoCar\Contracts\Repositories\DemandeFournisseurRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\DevisAutocarRepositoryContract;
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierDemandeFournisseurDelete;
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierDemandeFournisseurRefuse;
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierDemandeFournisseurValidate;
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierFournisseurBpa;
use Modules\CrmAutoCar\Models\DemandeFournisseur;
use Modules\CrmAutoCar\Models\Fournisseur;
use Modules\CrmAutoCar\Models\Traits\EnumStatusDemandeFournisseur;
use Modules\DevisAutoCar\Models\Devi;

class BlockFournisseurItem extends Component
{
    public $fourni;
    public $demande;
    public $devi;
    public $price = null;
    public $editPrice = false;
    public $bpa = false;

    protected $listeners = ['update' => '$refresh'];

    protected $rules = [
        'fournisseur_id' => 'required',
        'devi_id' => 'required',

    ];

    public function mount(DemandeFournisseur $demande) {

        $this->demande = $demande;
        $this->fourni = $demande->fournisseur;
        $this->devi = $demande->devis;
        $this->price = $demande->prix ?? '--';
        $this->bpa = $demande->bpa ?? false;
    }

    public function editerPrice(){
        $this->editPrice = true;
    }

    public function closePrice(){
        $this->editPrice = false;
    }

    public function bpa(DemandeFournisseurRepositoryContract $demandRep)
    {
        $demandRep->update($this->demande, ['status' => EnumStatusDemandeFournisseur::STATUS_BPA]);
        (new FlowCRM())->add($this->devi->dossier , new ClientDossierFournisseurBpa(Auth::user(), $this->devi, $this->fourni));

        $this->emit('update');

        return redirect(route('dossiers.show', [$this->devi->dossier->client, $this->devi->dossier]))
            ->with('success', 'Fournisseur validé');
    }

    public function savePrice(DemandeFournisseurRepositoryContract $demandRep) {
        if($this->price != null)
        {
            $demandRep->update($this->demande, ['prix' => $this->price]);
        }
        $this->closePrice();
        $this->emit('update');
        $this->emit('refreshProforma');
    }

    public function validateDemande(DemandeFournisseurRepositoryContract $demandRep)
    {
        if($this->price != null && $this->price != "--" && $this->price != 0) {
            $demandRep->update($this->demande, ['status' => EnumStatusDemandeFournisseur::STATUS_VALIDATE]);

            $proforma = $this->devi->proformat;
            if($proforma && !$proforma->acceptation_date) {
                $proforma->acceptation_date = now();
                $proforma->save();
            }

            $prix = (float) $this->demande->prix;
            (new FlowCRM())->add($this->devi->dossier, new ClientDossierDemandeFournisseurValidate(Auth::user(), $this->devi, $this->fourni, $prix));

            $this->emit('update');
            $this->emit('refreshProforma');
        }else{
            return redirect(route('dossiers.show', [$this->devi->dossier->client, $this->devi->dossier]))
                ->with('error', 'Pas de prix sur le fournisseur');
        }
    }

    public function refuseDemande(DemandeFournisseurRepositoryContract $demandRep)
    {
            $demandRep->update($this->demande, ['status' => EnumStatusDemandeFournisseur::STATUS_REFUSED]);
            (new FlowCRM())->add($this->devi->dossier, new ClientDossierDemandeFournisseurRefuse(Auth::user(), $this->devi, $this->fourni));
            $this->emit('update');
            $this->emit('refreshProforma');
    }

    public function delete(DemandeFournisseurRepositoryContract $demandRep)
    {
        $demandRep->cancel($this->demande);
        (new FlowCRM())->add($this->devi->dossier, new ClientDossierDemandeFournisseurDelete(Auth::user(), $this->devi, $this->fourni));
        $this->emit('update');
    }

    public function render()
    {
        return view('crmautocar::livewire.block-fournisseur-item');
    }
}
