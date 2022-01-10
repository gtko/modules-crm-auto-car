<?php

namespace Modules\CrmAutoCar\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Modules\BaseCore\Repositories\AbstractRepository;
use Modules\CrmAutoCar\Contracts\Repositories\StatistiqueReservationRepositoryContract;
use Modules\CrmAutoCar\Models\Proformat;

class StatistiqueReservationRepository extends AbstractRepository implements StatistiqueReservationRepositoryContract
{

    protected function getQueryCached(?Carbon $dateStart = null, ?Carbon $dateEnd = null):Collection
    {
        return Cache::remember('reservation_all', 20, function(){
            return $this->newQuery()->with('payments')->get();
        });
    }

    public function getTotalVente(?Carbon $dateStart = null, ?Carbon $dateEnd = null): float
    {
        return $this->getQueryCached()->sum(function($item){
            return $item->price->getPriceTTC();
        });
    }

    public function getTotalAchat(?Carbon $dateStart = null, ?Carbon $dateEnd = null): float
    {
        return $this->getQueryCached()->sum(function($item){
            return $item->price->getPriceAchat();
        });
    }

    public function getTotalMargeHT(?Carbon $dateStart = null, ?Carbon $dateEnd = null): float
    {
        return $this->getQueryCached()->sum(function($item){
            return $item->price->getMargeHT();
        });
    }

    public function getTotalAEncaisser(?Carbon $dateStart = null, ?Carbon $dateEnd = null): float
    {
        return $this->getQueryCached()->sum(function($item){
            return $item->price->remains();
        });
    }

    public function getModel(): Model
    {
       return (new Proformat());
    }

    public function searchQuery(Builder $query, string $value, mixed $parent = null): Builder
    {
        return $query;
    }
}
