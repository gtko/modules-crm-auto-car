<?php

namespace Modules\CrmAutoCar\Flow\Attributes;

use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;
use Modules\CrmAutoCar\Contracts\Repositories\ProformatsRepositoryContract;
use Modules\CrmAutoCar\Models\Payment;
use Modules\CrmAutoCar\Models\Proformat;

class CreatePaiementClient extends Attributes
{

    public function __construct(
        public Payment $payment
    ){
      parent::__construct();
    }

    public static function instance(array $value): FlowAttributes
    {
        $payment = Payment::find($value['payment_id']);
        return new CreatePaiementClient($payment);
    }

    public function toArray(): array
    {
        return [
            'payment_id' => $this->payment->id
        ];
    }

    public function getPayment():Payment
    {
        return $this->payment;
    }
}
