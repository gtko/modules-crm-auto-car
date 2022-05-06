<?php

namespace Modules\CrmAutoCar\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\DevisAutoCar\Models\Devi;

class Fournisseur extends \Modules\CoreCRM\Models\Fournisseur
{

    public function devis():BelongsToMany
    {
        return $this->belongsToMany(Devi::class, 'devi_fournisseurs', 'user_id', 'devi_id')
            ->withPivot('prix', 'validate', 'mail_sended', 'bpa')
            ->wherePivot('validate', true);
    }

    public function demandeFournisseurs(): HasMany
    {
        return $this->hasMany(DemandeFournisseur::class, 'user_id');
    }

}
