<?php

namespace Modules\CrmAutoCar\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;

/**
 * @property int $id
 * @property int $devis_id
 * @property string $number
 * @property array $data
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Modules\CoreCRM\Contracts\Entities\DevisEntities $devis
 */
class Proformat extends Model
{

    protected $fillable = ['devis_id', 'number', 'total', 'data'];

    protected $casts = [
        'avoirs' => 'array',
        'data' => 'array',
    ];

    public function devis():BelongsTo
    {
        return $this->belongsTo(app(DevisEntities::class)::class, 'devis_id', 'id');
    }

    public function payments():HasMany
    {
        return $this->hasMany(Payment::class);
    }


}