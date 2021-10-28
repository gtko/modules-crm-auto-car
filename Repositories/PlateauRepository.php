<?php

namespace Modules\CrmAutoCar\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\CoreCRM\Models\Commercial;
use Modules\CrmAutoCar\Contracts\Repositories\PlateauRepositoryContract;

class PlateauRepository implements PlateauRepositoryContract
{

    public function filterByStatus(Commercial $commercial): Collection
    {
        return $commercial->dossiers->groupBy("status.label");
    }

    public function filterTagByStatus(Commercial $commercial, string $status): Collection
    {
        $collection = $commercial->dossiers->where('status.label', $status);
//        $collection = $collection->groupby('tags.label');
//        dd($collection);
        return $collection;

    }
}