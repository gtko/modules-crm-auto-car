<?php

namespace Modules\CrmAutoCar\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use function Symfony\Component\String\b;

/**
 * @property int $id
 * @property int $proformat_id
 * @property array $data
 * @property float $total
 * @property Carbon $date_payment
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Modules\CrmAutoCar\Models\Proformat $proformat
 */
class Payment extends Model
{

    protected $fillable = [
        'proformat_id', 'total', 'data'
    ];

    protected $casts = [
        'data' => 'array',
        'date_payment' => 'date'
    ];

    public function proformat():BelongsTo
    {
        return $this->belongsTo(Proformat::class);
    }

}
