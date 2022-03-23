<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Flow\Attributes\SendContactChauffeurToClient;
use Modules\CoreCRM\Models\Fournisseur;
use Modules\CoreCRM\Services\FlowCRM;
use Modules\CrmAutoCar\Contracts\Repositories\ContactFournisseurRepositoryContract;
use Modules\CrmAutoCar\Flow\Attributes\DevisSendManualClient;
use Modules\CrmAutoCar\Models\Dossier;

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

    public function getListeners()
    {
        return [
            'sendchauffeur:confirm_'.$this->contact->id => 'sendConfirm'
        ];
    }

    public function sendContactChauffeur()
    {

        $flowable = $this->contact->dossier;

        $this->emit('send-mail:open', [
            'flowable' => [Dossier::class, $flowable->id],
            'observable' => [
                [
                    SendContactChauffeurToClient::class,
                    [
                        'user_id' => Auth::user()->id,
                        'devi_id' => $this->contact->devi->id,
                        'fournisseur_id' => $this->contact->fournisseur->id,
                    ]
                ]
            ],
            'callback' => 'sendchauffeur:confirm_'.$this->contact->id
        ]);



    }

    public function sendConfirm(){
        app(ContactFournisseurRepositoryContract::class)->send($this->contact);
        return redirect(route('dossiers.show', [$this->contact->dossier->client, $this->contact->dossier]))
            ->with('success', 'Informations voyages envoyée avec succès');
    }

    public function render()
    {
        $fournisseur = $this->contact->fournisseur;
        return view('crmautocar::livewire.contact-chauffeur-fournisseur-item', compact('fournisseur'));
    }
}
