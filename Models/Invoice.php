<?php

namespace Modules\CrmAutoCar\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;

class Invoice extends Model
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

}
