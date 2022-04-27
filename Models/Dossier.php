<?php

namespace Modules\CrmAutoCar\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
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

    /**
     * @return bool
     */
    public function getSignedAttribute():bool
    {
        $signed = false;
        foreach($this->devis as $devis){
            if($devis->proformat){
                $signed = true;
            }
        }

        return $signed;
    }

    public function getSignatureAtAttribute(){
        $dateSignature = null;
        foreach($this->devis as $devis){
            if($devis->proformat){
                if($dateSignature === null || $devis->proformat->created_at->lessThan($dateSignature)) {
                    $dateSignature = $devis->proformat->created_at;
                }
            }
        }

        return $dateSignature;
    }

}
