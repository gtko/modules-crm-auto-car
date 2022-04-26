<?php

namespace Modules\CrmAutoCar\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\CoreCRM\Models\Commercial;
use Modules\CoreCRM\Models\User;
use Modules\CrmAutoCar\Contracts\Repositories\PlateauRepositoryContract;

class PlateauRepository implements PlateauRepositoryContract
{

    public function filterByStatus(Commercial $commercial): Collection
    {
        return $commercial->dossiers->groupBy("status.label");
    }


    public function filterByTags(Commercial $commercial): Collection
    {
        return $commercial->dossiers->groupBy("tags.label");
    }

    public function filterFollowerByStatus(UserEntity $commercial): Collection
    {
        return $commercial->dossiersFollower->groupBy("status.label");
    }
}
