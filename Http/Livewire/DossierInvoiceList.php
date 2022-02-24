<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\CoreCRM\Models\Dossier;
use Modules\CrmAutoCar\Actions\CreateInvoice;
use Modules\CrmAutoCar\Contracts\Repositories\DevisAutocarRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\InvoicesRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\ProformatsRepositoryContract;
use Modules\CrmAutoCar\Models\Invoice;
use Modules\CrmAutoCar\Models\Payment;

class DossierInvoiceList extends Component
{

    public $dossier;
    public $client;

    public $proforma_select = null;

    protected $rules = [
        'proforma_select' => 'required'
    ];

    public function mount(ClientEntity $client, Dossier $dossier){
        $this->client = $client;
        $this->dossier = $dossier;
    }


    public function createInvoice(ProformatsRepositoryContract $proformatRep){

        if(Auth::user()->cannot('create', Invoice::class)){
            abort(403);
        }

        $this->validate();

        $proforma = $proformatRep->fetchById($this->proforma_select);
        $invoice = (new CreateInvoice())->create($proforma->devis);

        session()->flash('success', 'Facture ajouté au dossier');

        return redirect()->route('dossiers.show', [$this->client, $this->dossier, 'tab' => 'invoices']);
    }

    public function render(InvoicesRepositoryContract $invoiceRep, ProformatsRepositoryContract $proFormaRep)
    {
        if(Auth::user()->cannot('viewAny', Invoice::class)){
            abort(403);
        }

        $invoices = $invoiceRep->newQuery()->whereIn('devis_id', $this->dossier->devis->pluck('id'))->get();
        $proformas = $proFormaRep->newQuery()->whereHas('devis', function($query){
           $query->whereHas('dossier', function($query){
               $query->where('id', $this->dossier->id);
           });
        })->whereNotIn('devis_id',$invoices->pluck('devis_id'))
            ->get();

        return view('crmautocar::livewire.dossier-invoice-list', compact('invoices', 'proformas'));
    }
}
