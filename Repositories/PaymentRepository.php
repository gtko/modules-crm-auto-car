<?php

namespace Modules\CrmAutoCar\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\BaseCore\Repositories\AbstractRepository;
use Modules\CrmAutoCar\Contracts\Repositories\PaymentRepositoryContract;
use Modules\CrmAutoCar\Models\Invoice;
use Modules\CrmAutoCar\Models\Payment;
use Modules\CrmAutoCar\Models\Proformat;

class PaymentRepository extends AbstractRepository implements PaymentRepositoryContract
{

    public function getModel(): Model
    {
        return new Payment();
    }

    public function create(Proformat $proformat, Float $total,  array $data, Carbon $date_payment = null): Payment
    {

        $payment = new Payment();
        $payment->proformat_id = $proformat->id;
        $payment->total = $total;
        $payment->date_payment = $date_payment;
        $payment->data = $data;
        $payment->save();

        dd($date_payment);

        return $payment;
    }

    public function searchQuery(Builder $query, string $value, mixed $parent = null): Builder
    {
       return $query->where('total', $value)->orWhere('id', $value);
    }

    public function delete(Payment $payment): Bool
    {
        return $payment->delete();

    }
}
