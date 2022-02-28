<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\FournisseurRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\TagFournisseurRepositoryContract;
use Modules\CoreCRM\Services\FlowCRM;
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierDemandeFournisseurDelete;
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierDemandeFournisseurSend;
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierDemandeFournisseurValidate;
use Modules\CrmAutoCar\Flow\Attributes\DevisSendClient;
use Modules\CrmAutoCar\Models\Dossier;


class BlockFournisseur extends Component
{
    public $dossier;
    public $fournisseurs;
    public $tags;
    public $fournisseur_id;
    public $tag_id;
    public $devi_id;
    public $price = null;
    public $editPrice = false;

    protected $listeners = ['update' => '$refresh'];

    protected $rules = [
        'fournisseur_id' => 'required_without:tag_id',
        'tag_id' => 'required_without:fournisseur_id',
        'devi_id' => 'required',
    ];

    public function mount(FournisseurRepositoryContract $repFournisseur, $client, $dossier)
    {
        $this->dossier = $dossier->load('devis');
        $this->fournisseurs = $repFournisseur->getAllList();
        $this->tags = app(TagFournisseurRepositoryContract::class)->all();

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

        $observables = [];


        foreach(($this->fournisseur_id ?? []) as $fournisseur_id){
            $observables[] = [
                    ClientDossierDemandeFournisseurSend::class,
                    [
                        'user_id' => Auth::id(),
                        'devis_id' => $this->devi_id,
                        'fournisseur_id' => $fournisseur_id,
                    ]
                ];
        }

        $tagRep  = app(TagFournisseurRepositoryContract::class);
        foreach(($this->tag_id ?? []) as $tag_id) {
            $tag = $tagRep->newQuery()->find($tag_id);
            foreach ($tag->fournisseurs as $fournisseur)
            {
                $observables[] = [
                    ClientDossierDemandeFournisseurSend::class,
                    [
                        'user_id' => Auth::id(),
                        'devis_id' => $this->devi_id,
                        'fournisseur_id' => $fournisseur->id,
                    ]
                ];
            }
        }


        $this->emit('send-mail:open', [
            'flowable' => [Dossier::class, $this->dossier->id],
            'observable' => $observables,
        ]);


        //$this->emit('popup-mail:open', ['fournisseur_id' => $this->fournisseur_id, 'devi_id' => $this->devi_id, 'dossier' => $this->dossier]);
    }

    public function savePrice(DevisRepositoryContract $repDevi, FournisseurRepositoryContract $repFournisseur, int $devisId, int $fournisseurId) {
        if($this->price != null)
        {
            $repDevi->savePriceFournisseur($this->devis, $this->fournisseur, $this->price[$fournisseurId]);
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
