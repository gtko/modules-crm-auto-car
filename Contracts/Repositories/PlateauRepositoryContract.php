<?php

namespace Modules\CrmAutoCar\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\CoreCRM\Models\Commercial;

interface PlateauRepositoryContract
{
    public function filterByStatus(Commercial $commercial): Collection;
    public function filterTagByStatus(Commercial $commercial, string $status) :Collection;
}
