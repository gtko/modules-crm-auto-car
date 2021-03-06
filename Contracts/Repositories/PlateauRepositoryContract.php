<?php

namespace Modules\CrmAutoCar\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\CoreCRM\Models\Commercial;

interface PlateauRepositoryContract
{
    public function filterByStatus(Commercial $commercial): Collection;
    public function filterFollowerByStatus(Commercial $commercial): Collection;
    public function filterByTags(Commercial $commercial) :Collection;


}
