<?php

namespace Modules\CrmAutoCar\Models\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\CrmAutoCar\Models\Invoice;

/**
 * Trait hasCanceled
 * @property string $status
 * @property int $canceled_id
 */
trait hasCanceled
{



    public function hasCanceled(){
        return $this->status === self::STATUS_CANCELED;
    }

    public function isCanceller(){
        return false;//!$this->original;
    }

    public function canceled():BelongsTo
    {
        return $this->belongsTo(self::class, 'cancel_id', 'id');
    }

    public function original():HasOne
    {
        return $this->hasOne(self::class, 'cancel_id', 'id');
    }

}
