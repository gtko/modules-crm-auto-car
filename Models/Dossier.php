<?php

namespace Modules\CrmAutoCar\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Modules\TaskCalendarCRM\Models\Task;

class Dossier extends \Modules\CoreCRM\Models\Dossier
{

    public $with = ['client', 'commercial'];

    public function getMorphClass()
    {
        return \Modules\CoreCRM\Models\Dossier::class;
    }

    public function contactFournisseurs():HasMany
    {
        return $this->hasMany(ContactFournisseur::class);
    }

    public function tasks():MorphMany
    {
        return $this->morphMany(Task::class, 'taskable');
    }

}
