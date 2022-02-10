<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

use Modules\CoreCRM\Flow\Attributes\SendContactChauffeurToClient;
use Modules\CoreCRM\Services\FlowCRM;
use Modules\CrmAutoCar\Contracts\Repositories\ContactFournisseurRepositoryContract;

class ContactChauffeurFournisseurItem extends Component
{

    public $contact;

    public function mount($contact)
    {
        $this->contact = $contact;
    }

    public function removeContact()
    {
        app(ContactFournisseurRepositoryContract::class)->delete($this->contact);
        $this->emit('contactchauffeurfournisseur::refresh');
    }

    public function sencContactChauffeur()
    {
        app(ContactFournisseurRepositoryContract::class)->send($this->contact);
        (new FlowCRM())->add($this->contact->dossier, new SendContactChauffeurToClient(Auth::user(), $this->contact->devi, $this->contact->fournisseur));
    }

    public function render()
    {
        $fournisseur = $this->contact->fournisseur;
        return view('crmautocar::livewire.contact-chauffeur-fournisseur-item', compact('fournisseur'));
    }
}
