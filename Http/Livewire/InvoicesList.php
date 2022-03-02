<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CrmAutoCar\Actions\CreateInvoice;
use Modules\CrmAutoCar\Contracts\Repositories\InvoicesRepositoryContract;
use Modules\CrmAutoCar\Models\Invoice;

class InvoicesList extends Component
{

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render(InvoicesRepositoryContract $invoiceRep)
    {

        $query = $invoiceRep->newQuery();

        $query->whereHas('devis', function($query){
            $query->whereHas('proformat');
        });

        $invoiceRep->setQuery($query);

        $start = now()->subDays(90);
        $end = now()->addDays(7);

        return view('crmautocar::livewire.invoices-list', [
            'invoices' => $invoiceRep->fetchAll(100),
            'stats' => [
                'ca' => $invoiceRep->statsChiffreAffaire($start, $end),
                'nb' => $invoiceRep->statsNombreFacture($start, $end),
                'marge' => $invoiceRep->statsMargeTotal($start, $end),
                'panier_moyen' => $invoiceRep->statsPanierMoyen($start, $end),
                'encaisser' => $invoiceRep->statsEncaisser($start, $end),
                'non_payer' => $invoiceRep->statsNonPayer($start, $end),
                'tva' => $invoiceRep->statsTva($start, $end),
                'avoir' => $invoiceRep->statsAvoir($start, $end),
            ]
        ]);
    }
}
