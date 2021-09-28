<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\FournisseurRepositoryContract;
use Modules\CrmAutoCar\Mail\RequestFournisseurMail;

class BlockFournisseur extends Component
{
    public $dossier;
    public $fournisseurs;

    public function mount(FournisseurRepositoryContract $repFournisseur, $client, $dossier)
    {
        $this->dossier = $dossier;
        $this->fournisseurs = $repFournisseur->getAllList();

    }

    public function send()
    {

        Mail::to(['d@gmail.com', 'test@test.com'])->send(new RequestFournisseurMail($this->dossier, 'test'));

    }

    public function render()
    {
        return view('crmautocar::livewire.block-fournisseur');
    }
}
