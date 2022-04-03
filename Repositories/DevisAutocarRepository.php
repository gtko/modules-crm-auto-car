<?php

namespace Modules\CrmAutoCar\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Models\Fournisseur;
use Modules\CoreCRM\Repositories\DevisRepository;
use Modules\CrmAutoCar\Contracts\Repositories\DevisAutocarRepositoryContract;

class DevisAutocarRepository extends DevisRepository implements DevisAutocarRepositoryContract
{

    public function newQuery(): Builder
    {
        if(Auth::check()) {
            $bureaux = Auth::user()->roles->whereIn('id', config('crmautocar.bureaux_ids'));
            return parent::newQuery()->whereHas('commercial', function ($query) use ($bureaux) {
                $query->whereHas('roles', function ($query) use ($bureaux) {
                    $query->whereIn('id', $bureaux->pluck('id'));
                });
            });
        }

        return parent::newQuery();
    }

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
