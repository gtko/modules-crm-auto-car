<?php

namespace Modules\CrmAutoCar\Models\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Trait hasCanceled
 * @property string $status
 * @property int $canceled_id
 */
trait hasCanceled
{

    public function hasCancel(){
        return $this->hasCanceled() || $this->hasCanceller();
    }

    public function hasCanceled(){
        return $this->status === EnumStatusCancel::STATUS_CANCELED;
    }

    public function hasCanceller(){
        return $this->status === EnumStatusCancel::STATUS_CANCELLER;
    }

    public function canceled():BelongsTo
    {
        return $this->belongsTo(self::class, 'cancel_id', 'id');
    }
//
//    public function original():HasOne
//    {
//        return $this->hasOne(self::class, 'cancel_id', 'id');
//    }

}
