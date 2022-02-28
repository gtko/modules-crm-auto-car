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
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierDemandeFournisseurDelete;
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierPaiementFournisseurSend;

class BlockPaimentFournisseur extends Component
{

    public $fournisseur_id;
    public $devi_id;
    public $payer;
    public $fournisseurs;
    public $reste;
    public $total;
    public $paiements;
    public $date;

    protected $rules = [
        'fournisseur_id' => 'required',
        'devi_id' => 'required',
        'reste' => '',
        'payer' => 'required|numeric|min:1',
        'date' => 'required'
    ];

    public function mount($client, $dossier)
    {
        $this->dossier = $dossier;
    }

    public function updatedDeviId($deviId)
    {
        $this->devi_id = $deviId;
        $repDevi = app(DevisRepositoryContract::class);
        $deviModel = $repDevi->fetchById($deviId);
        $this->fournisseurs = $repDevi->getFournsisseurValidate($deviModel);
    }

    public function updatedFournisseurId($fournisseurId)
    {
        if($fournisseurId) {
            $repDevi = app(DevisRepositoryContract::class);
            $repFourni = app(FournisseurRepositoryContract::class);
            $repDecaissement = app(DecaissementRepositoryContract::class);

            $fourniModel = $repFourni->fetchById($fournisseurId);
            $deviModel = $repDevi->fetchById($this->devi_id);
            $this->total = $repDevi->getPrice($deviModel, $fourniModel);
            $this->payer = $repDecaissement->getPayer($deviModel, $fourniModel);

            if ($this->payer == null) {
                $this->reste = $this->total;
            } else {
                $this->reste = $this->total - $this->payer;
            }
            $this->payer = 0;
        }else{
            $this->reset([
                'fournisseur_id',
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
        $repDevi = app(DevisRepositoryContract::class);
        $repFourni = app(FournisseurRepositoryContract::class);

        $deviModel = $repDevi->fetchById($this->devi_id);
        $fourniModel = $repFourni->fetchById($this->fournisseur_id);

        $this->reste = $this->reste - $this->payer ;

        $date = (new DateStringToCarbon())->handle($this->date);
        $decaissement = $repDecaissement->create($deviModel, $fourniModel, $this->payer, $this->reste, $date);

        $this->fournisseur_id = '';
        $this->devi_id = '';

        (new FlowCRM())->add($this->dossier , new ClientDossierPaiementFournisseurSend(Auth::user(), $deviModel, $fourniModel, $decaissement));
    }

    public function render()
    {
        $repDecaissement = app(DecaissementRepositoryContract::class);
        $this->paiements = $repDecaissement->getByDossier($this->dossier);


        return view('crmautocar::livewire.block-paiment-fournisseur');
    }
}
