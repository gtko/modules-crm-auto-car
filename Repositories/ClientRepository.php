<?php

namespace Modules\CrmAutoCar\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\CrmAutoCar\Models\Client;

class ClientRepository extends \Modules\CoreCRM\Repositories\ClientRepository
{

    public function newQuery(): Builder
    {
//        if(Auth::check()) {
//            $bureaux = Auth::user()->roles->whereIn('id', config('crmautocar.bureaux_ids'));
//            return parent::newQuery()->whereHas('dossiers', function ($query) use ($bureaux) {
//                $query->whereHas('commercial', function ($query) use ($bureaux) {
//                    $query->whereHas('roles', function ($query) use ($bureaux) {
//                        $query->whereIn('id', $bureaux->pluck('id'));
//                    });
//                });
//            });
//        }

        return parent::newQuery();
    }


    public function getModel(): Model
    {
        return new Client();
    }

    public function searchQuery(Builder $query, string $value, mixed $parent = null):Builder
    {
        $query = parent::searchQuery($query, $value, $parent);

        $query->orWhere('company', 'like', '%' . $value . '%');

        return $query;
    }

}
