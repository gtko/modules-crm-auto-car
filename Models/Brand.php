<?php

namespace Modules\CrmAutoCar\Models;


use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\DevisAutoCar\Models\Devi;

/**
 * Class Brand
 * @property Collection $devis
 * @property int $id
 * @property string $label
 * @package App\Models
 * @mixin Builder
 * @mixin \Illuminate\Database\Query\Builder
 */
class Brand extends Model
{
    use HasFactory;

    protected $fillable = ['label'];

    protected array $searchableFields = ['*'];

    public function devis(): BelongsToMany
    {
        return $this->belongsToMany(Devi::class);
    }
}
