<?php

namespace Modules\CrmAutoCar\Flow\Attributes;

use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;
use Modules\CrmAutoCar\Contracts\Repositories\InvoicesRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\ProformatsRepositoryContract;
use Modules\CrmAutoCar\Models\Invoice;
use Modules\CrmAutoCar\Models\Proformat;

class CreateInvoiceClient extends Attributes
{

    public function __construct(
        public ?Invoice $invoice = null
    ){
      parent::__construct();
    }

    public static function instance(array $value): FlowAttributes
    {
        $invoice = app(InvoicesRepositoryContract::class)->fetchById($value['invoice_id'] ?? 0);
        return new CreateInvoiceClient($invoice);
    }

    public function toArray(): array
    {
        return [
            'invoice_id' => $this->invoice->id ?? ''
        ];
    }

    public function getInvoice():?Invoice
    {
        return $this->invoice;
    }
}
