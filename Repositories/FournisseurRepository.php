<?php

namespace Modules\CrmAutoCar\Repositories;

use Illuminate\Database\Eloquent\Model;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Contracts\Repositories\FournisseurRepositoryContract;
use Modules\CrmAutoCar\Models\Fournisseur;

class FournisseurRepository extends \Modules\CoreCRM\Repositories\FournisseurRepository
{

    public function getModel(): Model
    {
        return new Fournisseur();
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
