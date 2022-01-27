<?php

namespace Modules\CrmAutoCar\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Models\Fournisseur;
use Modules\CoreCRM\Repositories\DevisRepository;
use Modules\CrmAutoCar\Contracts\Repositories\DevisAutocarRepositoryContract;

class DevisAutocarRepository extends DevisRepository implements DevisAutocarRepositoryContract
{

    public function bpaFournisseur(DevisEntities $devis, Fournisseur $fournisseur, bool $bpa = true)
    {
        $devis->fournisseurs()->updateExistingPivot($fournisseur, ['bpa' => $bpa]);

        return $devis;
    }


    public function searchQuery(Builder $query, string $value, mixed $parent = null): Builder
    {
        return parent::searchQuery($query, $value, $parent)
            ->orWhere('title', 'like', '%' . $value . '%');
    }
}
