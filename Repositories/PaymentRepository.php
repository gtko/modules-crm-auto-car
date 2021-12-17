<?php

namespace Modules\CrmAutoCar\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\BaseCore\Repositories\AbstractRepository;
use Modules\CrmAutoCar\Contracts\Repositories\PaymentRepositoryContract;
use Modules\CrmAutoCar\Models\Invoice;
use Modules\CrmAutoCar\Models\Payment;

class PaymentRepository extends AbstractRepository implements PaymentRepositoryContract
{

    public function getModel(): Model
    {
        return new Payment();
    }

    public function create(Invoice $invoice, Float $total,  array $data): Payment
    {
        return Payment::create([
            'invoice_id' => $invoice->id,
            'total' => $total,
            'data' => $data
        ]);
    }

    public function searchQuery(Builder $query, string $value, mixed $parent = null): Builder
    {
       return $query->where('total', $value)->orWhere('id', $value);
    }
}
