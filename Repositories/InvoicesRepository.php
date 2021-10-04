<?php

namespace Modules\CrmAutoCar\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CrmAutoCar\Models\Invoice;
use Modules\SearchCRM\Entities\SearchResult;

class InvoicesRepository extends \Modules\BaseCore\Repositories\AbstractRepository implements \Modules\CrmAutoCar\Contracts\Repositories\InvoicesRepositoryContract
{

    public function getModel(): Model
    {
        return new Invoice();
    }

    public function getNextNumber(): string
    {
        $invoice = Invoice::orderBy('created_at', 'DESC')->first();
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
}
