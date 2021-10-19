<?php

namespace Modules\CrmAutoCar\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use function Symfony\Component\String\b;

/**
 * @property int $id
 * @property int $invoice_id
 * @property array $data
 * @property float $total
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Modules\CrmAutoCar\Models\Invoice $invoice
 */
class Payment extends Model
{

    protected $cats = [
        'data' => 'array'
    ];

    public function invoice():BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

}
