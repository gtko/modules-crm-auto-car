<?php

namespace Modules\CrmAutoCar\Models\Traits;

class EnumStatusDemandeFournisseur
{
    const STATUS_WAITING = 'waiting';
    const STATUS_VALIDATE = 'validate';
    const STATUS_REFUSED = 'refused';
    const STATUS_BPA = 'BPA';


    const HAS_ACHAT_VALIDE = [
        self::STATUS_BPA,
        EnumStatusCancel::STATUS_CANCELED,
        EnumStatusCancel::STATUS_CANCELLER
    ];

}
