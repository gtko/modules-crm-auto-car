<?php

namespace Modules\CrmAutoCar\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Modules\BaseCore\Repositories\AbstractRepository;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\BrandsRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\InvoicesRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\ProformatsRepositoryContract;
use Modules\CrmAutoCar\Models\Invoice;
use Modules\DevisAutoCar\Entities\DevisPrice;
use Modules\SearchCRM\Entities\SearchResult;

class InvoicesRepository extends AbstractRepository implements InvoicesRepositoryContract
{

    public function newQuery(): Builder
    {
        if(Auth::check()) {
            $bureaux = Auth::user()->roles->whereIn('id', config('crmautocar.bureaux_ids'));
            return parent::newQuery()->whereHas('devis', function ($query) use ($bureaux) {
                $query->whereHas('commercial', function ($query) use ($bureaux) {
                    $query->whereHas('roles', function ($query) use ($bureaux) {
                        $query->whereIn('id', $bureaux->pluck('id'));
                    });
                });
            });
        }

        return parent::newQuery();
    }

    public function getModel(): Model
    {
        return new Invoice();
    }

    public function getNextNumber(): string
    {
        $invoice = Invoice::orderBy('id', 'DESC')->first();
        $number = last(explode('-', $invoice->number ?? ''));
        if(!$number){
            $number = 0;
        }

        return Carbon::now()->format('Y').'-'.Carbon::now()->format('m').'-'.(++$number);
    }

    public function create(DevisEntities $devis, float $total, string $number): Invoice
    {
        return Invoice::create(['devis_id' => $devis->id, 'total' => $total, 'number' => $number]);
    }

    public function edit(Invoice $invoice, float $total): Invoice
    {
        $invoice->update(['total' => $total]);
        return $invoice;
    }

    public function addAvoir(Invoice $invoice, float $total): Invoice
    {
        $avoirs = $invoice->avoirs;
        $avoirs[] = ['total' => $total];
        $invoice->avoirs = $avoirs;
        $invoice->save();

        return $invoice;
    }

    public function updateNumber(Invoice $invoice, string $number): Invoice
    {
        $invoice->update(['number' => $number]);
        return $invoice;
    }

    public function searchQuery(Builder $query, string $value, mixed $parent = null): Builder
    {
        return $query->where('number', 'LIKE', '%'.$value.'%');
    }


    protected function getInvoicesByDate(Carbon $start, Carbon $end):\Illuminate\Database\Eloquent\Collection
    {
        return Cache::remember('invoices_by_date_'.$start->format('dmYHis')."_".$end->format('dmYHis'), 2, function() use ($start, $end){
            return $this->newQuery()->whereBetween('created_at', [$start, $end])->get();
        });
    }

    public function statsChiffreAffaire(Carbon $start, Carbon $end): float
    {
        return $this->getInvoicesByDate($start, $end)->sum('total');
    }

    public function statsNombreFacture(Carbon $start, Carbon $end): float
    {
        return $this->getInvoicesByDate($start, $end)->count();
    }

    public function statsMargeTotal(Carbon $start, Carbon $end): float
    {
        return $this->getInvoicesByDate($start, $end)->sum(function(Invoice $invoice){
            return $invoice->getPrice()->getMargeHT();
        });
    }

    public function statsPanierMoyen(Carbon $start, Carbon $end): float
    {
        $nbFacture = $this->statsNombreFacture($start, $end);

        if($nbFacture < 1){
            return 0;
        }

        return $this->statsChiffreAffaire($start, $end) / $nbFacture;
    }

    public function statsEncaisser(Carbon $start, Carbon $end): float
    {
        return $this->getInvoicesByDate($start, $end)->sum(function(Invoice $invoice){
            return $invoice->getPrice()->paid();
        });
    }

    public function statsNonPayer(Carbon $start, Carbon $end): float
    {
        return $this->getInvoicesByDate($start, $end)->sum(function(Invoice $invoice){
            return $invoice->getPrice()->remains();
        });
    }

    public function statsTVA(Carbon $start, Carbon $end): float
    {
        return $this->getInvoicesByDate($start, $end)->sum(function(Invoice $invoice){
            return $invoice->getPrice()->getPriceTTC() - $invoice->getPrice()->getPriceHT();
        });
    }

    public function statsAvoir(Carbon $start, Carbon $end): float
    {
        return $this->getInvoicesByDate($start, $end)->sum(function(Invoice $invoice){
            return $invoice->getPrice()->getTotalAvoirs();
        });
    }

    public function statsTropPercu(Carbon $start, Carbon $end): float
    {
        return $this->getInvoicesByDate($start, $end)->sum(function(Invoice $invoice){
            if($invoice->getPrice()->hasOverPaid()){
                return $invoice->getPrice()->overPaid();
            }

            return 0;
        });
    }

    public function cancel(Invoice $invoice): Invoice
    {
        DB::beginTransaction();
        $devisRep = app(DevisRepositoryContract::class);

        $devis = $invoice->devis;
        $proforma = $devis->proformat;

        //On duplique le devis
        $duplicateDevis = $devisRep->duplicate($devis);
        $data = $duplicateDevis->data;
        foreach(($data['trajets']  ?? []) as $indexTrajet => $trajet){
            foreach(($trajet['brands'] ?? []) as $indexBrand => $brand){
                $data['trajets'][$indexTrajet]['brands'][$indexBrand] = 0 - $data['trajets'][$indexTrajet]['brands'][$indexBrand];
            }
        }
        $duplicateDevis->data = $data;
        $duplicateDevis->save();

        $price = new DevisPrice($duplicateDevis, app(BrandsRepositoryContract::class)->getDefault());

        //On créer la proformat negative
        $proformaRep = app(ProformatsRepositoryContract::class);
        $numberProformat = $proformaRep->getNextNumber();
        $newProformat = $proformaRep->create($duplicateDevis, $price->getPriceTTC(), $numberProformat);

        //On créer la facture negative
        $invoiceRep = app(InvoicesRepositoryContract::class);
        $numberInvoice = $invoiceRep->getNextNumber();
        $newInvoice = $invoiceRep->create($duplicateDevis, $price->getPriceTTC(), $numberInvoice);

        //on deplace les paiements sur la nouvelle proformat
        $paiements = $proforma->payments;
        foreach($paiements as $paiement){
            $paiement->proformat_id = $newProformat->id;
            $paiement->save();
        }

        $invoice->status = Invoice::STATUS_CANCELED;
        $invoice->save();

        DB::commit();
        return $newInvoice;
    }
}
