<?php

namespace Modules\CrmAutoCar\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Contracts\Repositories\FournisseurRepositoryContract;
use Modules\CrmAutoCar\Models\Fournisseur;

class FournisseurRepository extends \Modules\CoreCRM\Repositories\FournisseurRepository
{

    protected $disabledVisibility = false;

    public function getModel(): Model
    {
        return new Fournisseur();
    }


    public function newQuery(): Builder
    {
        if($this->disabledVisibility){
            return parent::newQuery();
        }

        return parent::newQuery()->where('enabled', true);
    }

    public function disabled(){
        $this->disabledVisibility = true;
        return $this;
    }

    public function getBpaByDevis(DevisEntities $devis){

        return $this->newQuery()
            ->whereHas('devis', function ($query) use ($devis){
                $query->where('id', $devis->id);
                $query->where('bpa', true);
            })
            ->get();
    }
}
