<?php

namespace Modules\CrmAutoCar\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\CoreCRM\Models\Dossier;

/**
 * @property int $id
 * @property int $dossier_id
 * @property int $fournisseur_id
 * @property string $name
 * @property string $phone
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class ContactFournisseur extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['dossier_id','fournisseur_id','name', 'phone', 'created_at', 'updated_at'];

    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }

    public function dossier()
    {
        return $this->belongsTo(Dossier::class);
    }

}
