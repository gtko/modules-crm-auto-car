<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\CrmAutoCar\Flow\Attributes\DevisSendClient;
use Modules\CrmAutoCar\Flow\Attributes\SendInvoice;
use Modules\CrmAutoCar\Models\Dossier;
use Modules\CrmAutoCar\Models\Invoice;

class SendInvoiceEmail extends Component
{

    public $invoice;

    public function mount(Invoice $invoice){
        $this->invoice = $invoice;
    }

    public function getListeners()
    {
        return [
            'sendinvoice:confirm_'.$this->invoice->id => 'confirm'
        ];
    }

    public function sendInvoice(){
        $flowable = $this->invoice->devis->dossier;
        $this->emit('send-mail:open', [
            'flowable' => [Dossier::class, $flowable->id],
            'observable' => [
                [
                    SendInvoice::class,
                    [
                        'invoice_id' => $this->invoice->id,
                        'user_id' => Auth::id()
                    ]
                ]
            ],
            'callback' => 'sendinvoice:confirm_'.$this->invoice->id
        ]);
    }

    public function confirm($data){
        $flowable = $this->invoice->devis->dossier;
        session()->flash('success', 'Facture envoyé au client');
        return redirect()->route('dossiers.show', [$flowable->client, $flowable, $this->invoice->devis, 'tab'=> 'invoices']);
    }

    public function render()
    {
        return view('crmautocar::livewire.send-invoice-email');
    }
}
