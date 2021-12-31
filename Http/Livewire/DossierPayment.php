<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\CoreCRM\Contracts\Services\FlowContract;
use Modules\CoreCRM\Models\Dossier;
use Modules\CrmAutoCar\Actions\CreateInvoice;
use Modules\CrmAutoCar\Contracts\Repositories\InvoicesRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\PaymentRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\ProformatsRepositoryContract;
use Modules\CrmAutoCar\Flow\Attributes\CreatePaiementClient;

class DossierPayment extends Component
{
    public $dossier;
    public $client;

    public $paiement_proformat = null;
    public $paiement_total = 0;
    public $paiement_type = '';


    protected $rules = [
        'paiement_proformat' => 'required',
        'paiement_total' => 'required',
        'paiement_type' => 'required',
    ];

    public function mount(ClientEntity $client, Dossier $dossier){
        $this->client = $client;
        $this->dossier = $dossier;
    }


    public function addPaiment(PaymentRepositoryContract $paymentRep, ProformatsRepositoryContract $proformatRep){

        $this->validate();

        $proformat = $proformatRep->fetchById($this->paiement_proformat);
        $payment = $paymentRep->create($proformat, $this->paiement_total, [
            'type' => $this->paiement_type
        ]);

        app(FlowContract::class)->add($this->dossier, (new CreatePaiementClient($payment)));

        session()->flash('success', 'Paiement ajouté');

        $this->paiement_proformat = null;
        $this->paiement_total = 0;
        $this->paiement_type = '';

        return redirect()->route('dossiers.show', [$this->client, $this->dossier, 'tab' => 'payment']);

    }

    public function render(ProformatsRepositoryContract $proformatRep, PaymentRepositoryContract $paymentRep)
    {
        $proformats = $proformatRep->newQuery()->whereIn('devis_id', $this->dossier->devis->pluck('id'))->paginate(25);
        $payments = $paymentRep->newQuery()->whereIn('proformat_id', $proformats->pluck('id'))->paginate(25);

        return view('crmautocar::livewire.dossier-payment', compact('payments', 'proformats'));
    }
}
