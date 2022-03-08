<?php

namespace Modules\CrmAutoCar\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CrmAutoCar\Contracts\Repositories\BrandsRepositoryContract;
use Modules\CrmAutoCar\Entities\InvoicePrice;
use Modules\CrmAutoCar\Repositories\BrandsRepository;

/**
 * @property int $id
 * @property int $devis_id
 * @property string $number
 * @property array $data
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Database\Eloquent\Collection $payments
 * @property \Modules\CoreCRM\Contracts\Entities\DevisEntities $devis
 */
class Invoice extends Model
{

    const STATUS_CANCELED = 'canceled';
    const STATUS_NORMAL = 'normal';

    protected $fillable = ['devis_id', 'number', 'total', 'data'];

    protected $casts = [
        'avoirs' => 'array',
        'data' => 'array',
    ];


    public function devis():BelongsTo
    {
        return $this->belongsTo(app(DevisEntities::class)::class, 'devis_id', 'id');
    }

    public function getPrice():InvoicePrice
    {
        return (new InvoicePrice($this,app(BrandsRepositoryContract::class)->getDefault()));
    }

    public function isRefund():bool
    {
        return $this->total < 0;
    }

    public function hasCanceled(){
        return $this->status === self::STATUS_CANCELED;
    }

}
