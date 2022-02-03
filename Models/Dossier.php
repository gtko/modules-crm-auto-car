<?php

namespace Modules\CrmAutoCar\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dossier extends \Modules\CoreCRM\Models\Dossier
{

    public $with = ['client', 'commercial'];

    public function contactFournisseurs():HasMany
    {
        return $this->hasMany(ContactFournisseur::class);
    }
}
