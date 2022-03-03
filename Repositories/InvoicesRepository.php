<?php

namespace Modules\CrmAutoCar\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Modules\BaseCore\Repositories\AbstractRepository;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CrmAutoCar\Contracts\Repositories\InvoicesRepositoryContract;
use Modules\CrmAutoCar\Models\Invoice;
use Modules\SearchCRM\Entities\SearchResult;

class InvoicesRepository extends AbstractRepository implements InvoicesRepositoryContract
{

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
}
