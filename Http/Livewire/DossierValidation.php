<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\FournisseurRepositoryContract;
use Modules\CoreCRM\Flow\Attributes\ClientDossierNoteCreate;
use Modules\CoreCRM\Models\Dossier;
use Modules\CoreCRM\Services\FlowCRM;
use Modules\CrmAutoCar\Flow\Attributes\SendInformationVoyageMailFournisseur;

class DossierValidation extends Component
{
    public $dossier;
    public $client;
    public $devis;

    protected $listeners =
        [
          'refreshStatusDevis' => '$refresh'
        ];


    public function mount(ClientEntity $client, Dossier $dossier){
        $this->client = $client;
        $this->dossier = $dossier;
    }

    public function envoyer($devi_id)
    {
        $devis = app(DevisRepositoryContract::class)->fetchById($devi_id);
        $data = $devis->data;
        $data['sended'] = true;
        $devis->data = $data;
        $devis->save();

        //on get les fournisseurs en BPA et ont leur envoie la feuille de route
        $fournisseurs = app(FournisseurRepositoryContract::class)->getBpaByDevis($devis);

        foreach($fournisseurs as $fournisseur) {
            (new FlowCRM())->add($this->dossier, new SendInformationVoyageMailFournisseur(Auth::user(), $devis, [
                'fournisseur_name' => $fournisseur->format_name,
                'fournisseur_email' => $fournisseur->email,
                'fournisseur_id' => $fournisseur->id,
            ]));
        }

        return redirect()->route('dossiers.show', [$devis->dossier->client, $devis->dossier, 'tab' => 'validation'])
            ->with('success', 'La feuille de route a été envoyé avec succès');
    }

    public function openPopup($devi_id)
    {
        $this->emit('popup-validation-devis:open',['devi_id' => $devi_id]);
    }

    public function render()
    {
        $this->devis = $this->dossier->devis->filter(function($item){
           return $item['data']['validate'] ?? false;
        });

        return view('crmautocar::livewire.dossier-validation');
    }
}
