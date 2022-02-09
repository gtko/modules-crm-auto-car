<?php

namespace Modules\CrmAutoCar\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Models\Dossier;
use Modules\DevisAutoCar\Models\Devi;

/**
 * @property int $id
 * @property int $dossier_id
 * @property int $fournisseur_id
 * @property int $devi_id
 * @property string $name
 * @property string $phone
 * @property int $trajet_index
 * @property array $data
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 */
class ContactFournisseur extends Model
{
    /**
     * @var array
     */
    protected $casts = ['data' => 'array'];
    protected $fillable = ['dossier_id','fournisseur_id','name', 'phone', 'created_at', 'updated_at', 'devi_id', 'trajet_index', 'data'];

    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }

    public function dossier()
    {
        return $this->belongsTo(Dossier::class);
    }

    public function devi()
    {
        return $this->belongsTo(Devi::class);
    }

}
