<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Illuminate\Support\Facades\Request;
use Livewire\Component;
use Modules\BaseCore\Contracts\Repositories\AddressRepositoryContract;
use Modules\BaseCore\Contracts\Repositories\PersonneRepositoryContract;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Services\FlowCRM;
use Modules\CrmAutoCar\Contracts\Repositories\ProformatsRepositoryContract;
use Modules\CrmAutoCar\Flow\Attributes\ClientDevisExterneValidation;
use Modules\CrmAutoCar\Flow\Attributes\CreateProformatClient;
use Modules\DevisAutoCar\Entities\DevisPrice;

class CreateProformat extends Component
{
    public $devis;

    public function mount(DevisEntities $devis){
        $this->devis = $devis;
    }

    public function createProFormat(){

        $repDevi = app(DevisRepositoryContract::class);
        $proformatRep = app(ProformatsRepositoryContract::class);
        if(!$this->devis->proformat()->exists()) {
            $data = [
                'paiement_type_validation' => 'virement',
                'nom_validation' => $this->devis->dossier->client->lastname ?? '',
                'prenom_validation' => $this->devis->dossier->client->firstname ?? '',
                'societe_validation' => $this->devis->dossier->client->company ?? '',
                'country_id_validation' => $this->devis->dossier->client->personne->address->country->id ?? 150,
                'address_validation' => $this->devis->dossier->client->address ?? '',
                'code_zip_validation' => $this->devis->dossier->client->code_zip ?? '',
                'city_validation' => $this->devis->dossier->client->city ?? '',
                'ip_validation' => Request::ip()
            ];
            $repDevi->validatedDevis($this->devis, $data);

            $next = $proformatRep->getNextNumber();
            $proformat = $proformatRep->create($this->devis, $this->devis->getTotal(), $next);
            (new FlowCRM())->add($this->devis->dossier, new CreateProformatClient($proformat));
            (new FlowCRM())->add($this->devis->dossier, new ClientDevisExterneValidation($this->devis, Request::ip(), $data));
        }
        session()->flash('success', 'Votre devis a été validé');

        return redirect()->route('dossiers.show', [$this->devis->dossier->client, $this->devis->dossier, 'tab' => 'proforma']);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {

        return view('crmautocar::livewire.create-proformat');
    }
}
