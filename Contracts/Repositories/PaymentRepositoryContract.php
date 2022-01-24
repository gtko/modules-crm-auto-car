<?php

namespace Modules\CrmAutoCar\Contracts\Repositories;

use Carbon\Carbon;
use Modules\BaseCore\Interfaces\RepositoryFetchable;
use Modules\BaseCore\Interfaces\RepositoryQueryCustom;
use Modules\CrmAutoCar\Models\Invoice;
use Modules\CrmAutoCar\Models\Payment;
use Modules\CrmAutoCar\Models\Proformat;

interface PaymentRepositoryContract extends RepositoryFetchable, RepositoryQueryCustom
{
    public function create(Proformat $proformat,Float $total,  array $data, Carbon $date_payment = null):Payment;
    public function delete(Payment $payment): Bool;
}
