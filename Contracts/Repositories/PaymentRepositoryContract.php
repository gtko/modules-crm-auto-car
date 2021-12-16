<?php

namespace Modules\CrmAutoCar\Contracts\Repositories;

use Modules\BaseCore\Interfaces\RepositoryFetchable;
use Modules\BaseCore\Interfaces\RepositoryQueryCustom;
use Modules\CrmAutoCar\Models\Invoice;
use Modules\CrmAutoCar\Models\Payment;

interface PaymentRepositoryContract extends RepositoryFetchable, RepositoryQueryCustom
{
    public function create(Invoice $invoice,Float $total,  array $data):Payment;
}
