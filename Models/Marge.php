<?php

namespace Modules\CrmAutoCar\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\BaseCore\Contracts\Entities\UserEntity;

/**
 * @property int $id
 * @property int $proformat_id
 * @property int $user_id
 * @property float $marge
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \Modules\CrmAutoCar\Models\Proformat $proformat
 * @property-read \Modules\BaseCore\Contracts\Entities\UserEntity $user
 */
class Marge extends Model
{

    public $fillable = [
        'proformat_id',
        'user_id',
        'marge',
    ];

    public function proformat():BelongsTo{
        return $this->belongsTo(Proformat::class);
    }

    public function user():BelongsTo{
        return $this->belongsTo(app(UserEntity::class)::class);
    }
}
