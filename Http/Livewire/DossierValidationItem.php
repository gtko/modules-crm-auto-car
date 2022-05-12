<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\FournisseurRepositoryContract;
use Modules\CoreCRM\Models\Dossier;
use Modules\CrmAutoCar\Contracts\Repositories\DemandeFournisseurRepositoryContract;
use Modules\CrmAutoCar\Flow\Attributes\SendInformationVoyageMailFournisseur;
use Modules\CrmAutoCar\Models\Traits\EnumStatusDemandeFournisseur;
use Modules\DevisAutoCar\Models\Devi;

class DossierValidationItem extends Component
{
    public $dossier;
    public $devis;
    public $client;



    public function mount(Devi $devis){
        $this->devis = $devis;
        $this->dossier = $this->devis->dossier;
        $this->client = $this->dossier->client;
    }

    public function getListeners()
    {
        return [
            'refreshStatusDevis' => '$refresh',
            'dossiervalidation:confirm_'.$this->devis->id => 'confirmationSend'
        ];
    }

    public function confirmationSend(){
        $devis = app(DevisRepositoryContract::class)->fetchById($this->devis->id);
        $data = $devis->data;
        $data['sended'] = true;
        $devis->data = $data;
        $devis->save();

        return redirect()->route('dossiers.show', [$devis->dossier->client, $devis->dossier, 'tab' => 'validation'])
            ->with('success', 'La feuille de route a été envoyé avec succès');
    }

    public function envoyer(){
        $devis = app(DevisRepositoryContract::class)->fetchById($this->devis->id);

        $observables = [];
        $demandeRep = app(DemandeFournisseurRepositoryContract::class);
        $demandeRep->setQuery($demandeRep->newQuery()->where('status', EnumStatusDemandeFournisseur::STATUS_BPA));
        $demandes = $demandeRep->getDemandeByDevis($devis);

        foreach($demandes as $demande) {
            $fournisseur = $demande->fournisseur;
            $observables[] = [
                SendInformationVoyageMailFournisseur::class,
                [
                    'user_id' => Auth::id(),
                    'devis_id' => $this->devis->id,
                    'data' => [
                        'fournisseur_name' => $fournisseur->format_name,
                        'fournisseur_email' => $fournisseur->email,
                        'fournisseur_id' => $fournisseur->id,
                    ],
                ]
            ];
        }

        $this->emit('send-mail:open', [
            'flowable' => [\Modules\CrmAutoCar\Models\Dossier::class, $this->dossier->id],
            'observable' => $observables,
            'callback' => 'dossiervalidation:confirm_'.$this->devis->id,
        ]);
    }


    public function openPopup()
    {
        $this->emit('popup-validation-devis:open',['devi_id' => $this->devis->id]);
    }

    public function render()
    {
        return view('crmautocar::livewire.dossier-validation-item');
    }
}
