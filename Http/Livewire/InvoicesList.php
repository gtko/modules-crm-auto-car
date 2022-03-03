<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CrmAutoCar\Actions\CreateInvoice;
use Modules\CrmAutoCar\Contracts\Repositories\InvoicesRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\ProformatsRepositoryContract;
use Modules\CrmAutoCar\Models\Invoice;

class InvoicesList extends Component
{

    public $start;
    public $end;
    public $status;


    public $queryString = [
        'start', 'end', 'status'
    ];


    public function mount(){

    }

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

        if($this->start && $this->end) {
            $start = Carbon::parse($this->start)->startOfDay();
            $end = Carbon::parse($this->end)->endOfDay();

            if($end->copy()->startOfDay()->lessThan($start)){
                $start = $end->copy()->subDays(30)->startOfDay();
                $this->start = $start->format('Y-m-d');
            }

        }else{
            $start = now()->subDays(90);
            $end = now()->addDays(7);
        }

        $query->whereBetween('created_at', [$start, $end]);


        //status
        if($this->status) {
            $invoices = $query->with('devis.proformat.payments')->get();
            switch ($this->status) {
                case 'solder' :
                    $invoices = $invoices->filter(function ($invoice) {
                        return $invoice->total === $invoice->getPrice()->paid();
                    });
                    break;
                case 'pas_solder' :
                    $invoices = $invoices->filter(function ($invoice) {
                        return $invoice->total > $invoice->getPrice()->paid();
                    });
                    break;
                case 'trop_percu' :
                    $invoices = $invoices->filter(function ($invoice) {
                        return $invoice->total < $invoice->getPrice()->paid();
                    });
                    break;
            }

            $query->whereIn('id', $invoices->pluck('id'));
        }

        $invoiceRep->setQuery($query);

        $proformatRep = app(ProformatsRepositoryContract::class);


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
                'trop_percu' => $invoiceRep->statsTropPercu($start, $end),
                'to_invoice' => $proformatRep->toInvoice()->count()
            ]
        ]);
    }
}
