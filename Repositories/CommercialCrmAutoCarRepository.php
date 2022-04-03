<?php

namespace Modules\CrmAutoCar\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class CommercialCrmAutoCarRepository extends \Modules\CoreCRM\Repositories\CommercialRepository
{

    public function newQuery(): Builder
    {
        if(Auth::check()) {
            $bureaux = Auth::user()->roles->whereIn('id', config('crmautocar.bureaux_ids'));
            return parent::newQuery()->whereHas('roles', function ($query) use ($bureaux) {
                $query->whereIn('id', $bureaux->pluck('id'));
            });
        }

        return parent::newQuery();
    }

}
