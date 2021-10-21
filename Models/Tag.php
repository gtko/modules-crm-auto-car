<?php

namespace Modules\CrmAutoCar\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\CoreCRM\Models\Dossier;

/**
 * @property string $color
 * @property string $label
 * @property Carbon $created_at
 * @property Dossier $dossier
 */

class Tag extends Model
{
    public function dossiers(): BelongsToMany
    {
        return $this->belongsToMany(Dossier::class);
    }
}
