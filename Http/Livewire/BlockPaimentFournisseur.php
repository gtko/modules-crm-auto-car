<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\BaseCore\Actions\Dates\DateStringToCarbon;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\FournisseurRepositoryContract;
use Modules\CoreCRM\Services\FlowCRM;
use Modules\CrmAutoCar\Contracts\Repositories\DecaissementRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\DemandeFournisseurRepositoryContract;
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierDemandeFournisseurDelete;
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierPaiementFournisseurSend;
use Modules\CrmAutoCar\Models\Decaissement;
use Modules\CrmAutoCar\Models\Traits\EnumStatusDemandeFournisseur;

class BlockPaimentFournisseur extends Component
{

    public $payer;
    public $fournisseurs;
    public $reste;
    public $total;
    public $paiements;
    public $date;

    public $demande_id;

    protected $rules = [
        'demande_id' => 'required',
        'reste' => '',
        'payer' => 'required|numeric|min:1',
        'date' => 'date|required'
    ];

    public function mount($client, $dossier)
    {
        $this->dossier = $dossier;
    }

    public function updatedDemandeId($demandeID)
    {
        if($demandeID && $demandeID != 0) {
            $repDemande = app(DemandeFournisseurRepositoryContract::class);
            $repDecaissement = app(DecaissementRepositoryContract::class);

            $demandeModel = $repDemande->fetchById((int) $demandeID);
            $this->total = $demandeModel->prix ?? 0;
            $this->payer = $repDecaissement->getPayer($demandeModel);

            if ($this->payer == null) {
                $this->reste = $this->total;
            } else {
                $this->reste = $this->total - $this->payer;
            }
            $this->payer = 0;
        }else{
            $this->reset([
                'demande_id',
                'total',
                'payer',
                'reste'
            ]);
        }

    }

    public function payer()
    {
        $this->validate();
        $repDecaissement = app(DecaissementRepositoryContract::class);
        $repDemande = app(DemandeFournisseurRepositoryContract::class);
        $demandeModel = $repDemande->fetchById((int) $this->demande_id);

        $this->reste = $this->reste - $this->payer ;

        $date = (new DateStringToCarbon())->handle($this->date);
        $decaissement = $repDecaissement->create($demandeModel, $this->payer, $this->reste, $date);


        (new FlowCRM())->add($this->dossier , new ClientDossierPaiementFournisseurSend(Auth::user(), $demandeModel->devis, $demandeModel->fournisseur, $decaissement));

        $this->reset([
            'demande_id',
            'total',
            'payer',
            'reste'
        ]);
    }

    public function delete($decaissementID){
        Decaissement::where('id', $decaissementID)->delete();

        return redirect()
            ->back()
            ->with('success','Le paiement a été supprimé avec succès');
    }

    public function render(DemandeFournisseurRepositoryContract $demandeRep)
    {
        $repDecaissement = app(DecaissementRepositoryContract::class);
        $this->paiements = $repDecaissement->getByDossier($this->dossier);

        $demandeRep->setQuery($demandeRep->newQuery()
            ->where('status', '=', EnumStatusDemandeFournisseur::STATUS_BPA)
            ->orWhere('status', '=', EnumStatusDemandeFournisseur::STATUS_VALIDATE)
        );
        $demandes = $demandeRep->getDemandeByDossier($this->dossier);


        return view('crmautocar::livewire.block-paiment-fournisseur', compact('demandes'));
    }
}
