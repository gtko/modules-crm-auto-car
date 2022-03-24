<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\BaseCore\Actions\Dates\DateStringToCarbon;
use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\CoreCRM\Contracts\Services\FlowContract;
use Modules\CoreCRM\Models\Dossier;
use Modules\CrmAutoCar\Actions\CreateInvoice;
use Modules\CrmAutoCar\Contracts\Repositories\InvoicesRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\PaymentRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\ProformatsRepositoryContract;
use Modules\CrmAutoCar\Flow\Attributes\CreatePaiementClient;
use Modules\CrmAutoCar\Models\Payment;

class DossierPayment extends Component
{
    public $dossier;
    public $client;

    public $paiement_proformat = null;
    public $paiement_total = 0;
    public $paiement_type = '';
    public $paiement_date;


    protected $rules = [
        'paiement_proformat' => 'required',
        'paiement_total' => 'required',
        'paiement_type' => 'required',
        'paiement_date' => 'required',
    ];

    protected $listeners = [
        'refresh' => '$refresh'
    ];

    public function mount(ClientEntity $client, Dossier $dossier)
    {
        $this->client = $client;
        $this->dossier = $dossier;
    }

    public function delete(Payment $payment)
    {
        if(Auth::user()->cannot('delete', Payment::class)){
            abort(403);
        }

        app(PaymentRepositoryContract::class)->delete($payment);
        $this->emit('refresh');
    }


    public function getPriceProperty()
    {
        if ($this->paiement_proformat){
            $proformat = app(ProformatsRepositoryContract::class)
                ->fetchById($this->paiement_proformat);

            return $proformat->price;
        }

        return null;
    }

    public function addPaiment(PaymentRepositoryContract $paymentRep, ProformatsRepositoryContract $proformatRep)
    {
        if(Auth::user()->cannot('create', Payment::class)){
            abort(403);
        }

        $this->validate();

        if($this->paiement_type === 'remboursement' && $this->paiement_total > 0){
            $this->paiement_total = 0 - $this->paiement_total;
        }

        if($this->paiement_type === 'avoir' && $this->paiement_total > 0){
            $this->paiement_total = 0 - $this->paiement_total;
        }

        $date_payment = (new DateStringToCarbon())->handle($this->paiement_date);
        $proformat = $proformatRep->fetchById($this->paiement_proformat);
        $payment = $paymentRep->create($proformat, $this->paiement_total, [
            'type' => $this->paiement_type
        ], $date_payment);

        app(FlowContract::class)->add($this->dossier, (new CreatePaiementClient($payment)));

        session()->flash('success', 'Paiement ajouté');

        $this->paiement_proformat = null;
        $this->paiement_total = 0;
        $this->paiement_type = '';

        return redirect()->route('dossiers.show', [$this->client, $this->dossier, 'tab' => 'payment']);
    }

    public function render(ProformatsRepositoryContract $proformatRep, PaymentRepositoryContract $paymentRep)
    {
        if(Auth::user()->cannot('viewAny', Payment::class)){
            abort(403);
        }

        $proformats = $proformatRep->newQuery()->whereIn('devis_id', $this->dossier->devis->pluck('id'))->paginate(25);
        $payments = $paymentRep->newQuery()->whereIn('proformat_id', $proformats->pluck('id'))->paginate(25);

        return view('crmautocar::livewire.dossier-payment', compact('payments', 'proformats'));
    }
}
