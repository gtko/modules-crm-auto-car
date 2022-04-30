<?php

namespace Modules\CrmAutoCar\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Models\Fournisseur;

/**
 * @property float $restant
 * @property float $payer
 * @property Carbon $date
 * @property Carbon $created_at
 * @property DevisEntities $devi
 * @property int $devi_id
 * @property Fournisseur $fournisseur
 * @property int $fournisseur_id
 */

class Decaissement extends Model
{
    public function devis():BelongsTo
    {
        return $this->belongsTo(app(DevisEntities::class)::class, 'devis_id', 'id');
    }

    public function fournisseur():BelongsTo
    {
        return $this->belongsTo(Fournisseur::class);
    }

}
