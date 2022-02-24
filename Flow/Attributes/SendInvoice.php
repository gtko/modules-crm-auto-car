<?php

namespace Modules\CrmAutoCar\Flow\Attributes;

use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\BaseCore\Contracts\Repositories\UserRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;
use Modules\CoreCRM\Models\Dossier;
use Modules\CoreCRM\Models\User;
use Modules\CrmAutoCar\Contracts\Repositories\InvoicesRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\ProformatsRepositoryContract;
use Modules\CrmAutoCar\Models\Invoice;
use Modules\CrmAutoCar\Models\Proformat;

class SendInvoice extends Attributes
{

    public Invoice $invoice;
    public UserEntity $sender;

    public function __construct(Invoice $invoice, User $sender)
    {
        parent::__construct();

        $this->invoice = $invoice;
        $this->sender = $sender;
    }

    public static function instance(array $value): FlowAttributes
    {

        $invoice = app(InvoicesRepositoryContract::class)->fetchById($value['invoice_id']);
        $sender = app(UserRepositoryContract::class)->fetchById($value['user_id']);

        return new SendInvoice($invoice, $sender);
    }

    public function toArray(): array
    {
        return [
            'invoice_id' => $this->invoice->id,
            'user_id' => $this->sender->id,
        ];
    }


    public function getInvoice(): Invoice
    {
        return $this->invoice;
    }

    public function getSender(): UserEntity
    {
        return $this->sender;
    }
}
