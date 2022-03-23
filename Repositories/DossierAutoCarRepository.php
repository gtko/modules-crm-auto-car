<?php

namespace Modules\CrmAutoCar\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Modules\BaseCore\Helpers\HasInterface;
use Modules\CoreCRM\Contracts\Repositories\ClientRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\StatusRepositoryContract;

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



    public function countDossierResaBlanc(){
        return $this->newQuery()
            ->doesntHave('followers')
            ->whereHas('status', function ($query) {
                $status = app(StatusRepositoryContract::class)->fetchById('6');
                return $query->where('order', '>=', $status->order);
            })
            ->count();
    }

}
