<?php

namespace Modules\CrmAutoCar\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Modules\BaseCore\Models\Personne;
use Modules\CoreCRM\Models\User;
use Modules\TaskCalendarCRM\Models\Task;
use Spatie\Permission\Models\Role;

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

    public function personneClient(){
        return $this->hasOneThrough(Personne::class, Client::class, 'id', 'id', 'clients_id', 'personne_id');
    }

    public function personneCommercial(){
        return $this->hasOneThrough(Personne::class, User::class, 'id', 'id', 'commercial_id', 'personne_id');
    }



    public function getDateDepartAttribute(){
        return $this->data['date_depart'] ?? null;
    }

    public function getDateArriveAttribute(){
        return $this->data['date_arrivee'] ?? null;
    }

    public function getLieuDepartAttribute(){
        return $this->data['lieu_depart'] ?? null;
    }

    public function getLieuArriveAttribute(){
        return $this->data['lieu_arrivee'] ?? null;
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
