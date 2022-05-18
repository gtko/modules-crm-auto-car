<?php

namespace Modules\CrmAutoCar\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CrmAutoCar\Models\Traits\EnumStatusDemandeFournisseur;
use Modules\CrmAutoCar\Models\Traits\hasCanceled;
use Modules\DevisAutoCar\Models\Devi;

/**
 * @property int $id
 * @property int $devi_id
 * @property int $user_id
 * @property string $status
 * @property float $prix
 * @property float $payer
 * @property float $reste
 * @property boolean $validate
 * @property boolean $bpa
 * @property boolean $refused
 * @property string $mail_sended
 * @property string $created_at
 * @property string $updated_at
 */
class DemandeFournisseur extends Model
{

    use hasCanceled;

    protected $table = 'devi_fournisseurs';


    protected $fillable = [
        'devi_id',
        'user_id',
        'prix',
        'validate',
        'bpa',
        'refused',
        'mail_sended',
        'created_at',
        'updated_at',
        'status',
        'payer',
        'reste',
        'canceled_id'
    ];

    protected $dates = [
        'mail_sended'
    ];

    public function devis():BelongsTo
    {
        return $this->belongsTo(app(DevisEntities::class)::class,'devi_id');
    }

    public function fournisseur():BelongsTo
    {
        return $this->belongsTo(Fournisseur::class,'user_id');
    }

    public function decaissements():HasMany
    {
        return $this->hasMany(Decaissement::class,'demande_id');
    }


    public function computeStats(){

        $this->payer = $this->decaissements->sum('payer') ?? 0;
        $this->reste = $this->prix - $this->payer;
        $this->save();

        return $this;
    }

    public function isBPA():bool
    {
        return $this->status === EnumStatusDemandeFournisseur::STATUS_BPA;
    }

    public function isValidate():bool
    {
        return $this->status === EnumStatusDemandeFournisseur::STATUS_VALIDATE;
    }

    public function isRefused():bool
    {
        return $this->status === EnumStatusDemandeFournisseur::STATUS_REFUSED;
    }

    public function isCancel():bool
    {
        return $this->status === EnumStatusDemandeFournisseur::STATUS_CANCEL;
    }

    public function isSended():bool
    {
        return $this->mail_sended ;
    }

}
