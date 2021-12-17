<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\CoreCRM\Models\Dossier;
use Modules\CrmAutoCar\Actions\CreateInvoice;
use Modules\CrmAutoCar\Contracts\Repositories\DevisAutocarRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\InvoicesRepositoryContract;

class DossierInvoiceList extends Component
{

    public $dossier;
    public $client;

    public $devis_select = null;

    protected $rules = [
        'devis_select' => 'required'
    ];

    public function mount(ClientEntity $client, Dossier $dossier){
        $this->client = $client;
        $this->dossier = $dossier;
    }

    public function createInvoice(DevisAutocarRepositoryContract $devisRep){
        $this->validate();

        $devis = $devisRep->fetchById($this->devis_select);
        $invoice = (new CreateInvoice())->create($devis);

        session()->flash('success', 'Facture ajouté au dossier');

        return redirect()->route('dossiers.show', [$this->client, $this->dossier, 'tab' => 'invoices']);
    }

    public function render(InvoicesRepositoryContract $invoiceRep)
    {
        $invoices = $invoiceRep->newQuery()->whereIn('devis_id', $this->dossier->devis->pluck('id'))->paginate(25);
        $devis = $this->dossier->devis;

        return view('crmautocar::livewire.dossier-invoice-list', compact('invoices', 'devis'));
    }
}
