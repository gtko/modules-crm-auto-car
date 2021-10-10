<?php

namespace Modules\CrmAutoCar\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\BaseCore\Repositories\AbstractRepository;
use Modules\CrmAutoCar\Contracts\Repositories\BrandsRepositoryContract;
use Modules\CrmAutoCar\Models\Brand;

class BrandsRepository extends AbstractRepository implements BrandsRepositoryContract
{

    public function getModel(): Model
    {
        return new Brand();
    }


    public function searchQuery(Builder $query, string $value, mixed $parent = null): Builder
    {
        return $query->where('label', 'LIKE', '%'.$value.'%');
    }
}
