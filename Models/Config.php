<?php

namespace Modules\CrmAutoCar\Models;


use App\Models\Scopes\Searchable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\DevisAutoCar\Models\Devi;

/**
 * @property string $name
 * @property array $data
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */

class Config extends Model
{
    protected $cats = [
        'data' => 'array'
    ];

}
