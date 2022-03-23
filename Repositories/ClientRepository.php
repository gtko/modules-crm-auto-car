<?php

namespace Modules\CrmAutoCar\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\CrmAutoCar\Models\Client;

class ClientRepository extends \Modules\CoreCRM\Repositories\ClientRepository
{


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
