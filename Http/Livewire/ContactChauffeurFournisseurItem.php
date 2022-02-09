<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
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
    }

    public function render()
    {
        $fournisseur = $this->contact->fournisseur;
        return view('crmautocar::livewire.contact-chauffeur-fournisseur-item', compact('fournisseur'));
    }
}
