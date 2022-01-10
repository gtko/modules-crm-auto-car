<?php

namespace Modules\CrmAutoCar\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Modules\BaseCore\Helpers\HasInterface;
use Modules\CoreCRM\Contracts\Repositories\ClientRepositoryContract;

class DossierAutoCarRepository extends \Modules\CoreCRM\Repositories\DossierRepository
{
    public function searchQuery(Builder $query, string $value, mixed $parent = null): Builder
    {
        $query = parent::searchQuery($query, $value, $parent);

        if (!HasInterface::has(ClientRepositoryContract::class, $parent)) {
            $query->orWhereHas('client', function ($query) use ($value) {
                return app(ClientRepositoryContract::class)->searchQuery($query, $value, $this);
            });
        }

        return $query;
    }

}
