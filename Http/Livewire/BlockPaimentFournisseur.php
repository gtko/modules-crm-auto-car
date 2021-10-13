<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\FournisseurRepositoryContract;

class BlockPaimentFournisseur extends Component
{

    public $fournisseur_id;
    public $devi_id;
    public $payer;

    protected $rules = [
        'fournisseur_id' => 'required',
        'devi_id' => 'required'
    ];

    public function mount(FournisseurRepositoryContract $repFournisseur, $client, $dossier)
    {
        $this->dossier = $dossier;
        $this->fournisseurs = $repFournisseur->getAllList();

    }

    public function updateDeviId()
    {
        dd('salut');
    }

    public function render()
    {
        return view('crmautocar::livewire.block-paiment-fournisseur');
    }
}
