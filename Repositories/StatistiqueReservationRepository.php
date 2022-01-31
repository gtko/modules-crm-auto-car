<?php

namespace Modules\CrmAutoCar\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Modules\BaseCore\Repositories\AbstractRepository;
use Modules\CrmAutoCar\Contracts\Repositories\StatistiqueReservationRepositoryContract;
use Modules\CrmAutoCar\Models\Proformat;

class StatistiqueReservationRepository extends AbstractRepository implements StatistiqueReservationRepositoryContract
{

    protected function getQueryCached(?Carbon $dateStart = null, ?Carbon $dateEnd = null):Collection
    {
        $key = 'reservation_all';

        if($dateStart) {
            $key .= '_' . $dateStart->format('d-m-y-h-i-s');
        }

        if($dateEnd) {
            $key .= '_' . $dateEnd->format('d-m-y-h-i-s');
        }

        return Cache::remember($key, 1, function() use ($dateStart, $dateEnd){
            $query =  $this->newQuery()->with('payments', 'devis.dossier');
            if($dateStart && $dateEnd){
                $query->whereBetween('created_at', [$dateStart->startOfDay()->startOfMonth(), $dateEnd->endOfDay()->endOfMonth()]);
            }

            return $query->get();
        });
    }

    public function getTotalVente(?Carbon $dateStart = null, ?Carbon $dateEnd = null): float
    {
        return $this->getQueryCached($dateStart, $dateEnd)->sum(function($item){
            return $item->price->getPriceTTC();
        });
    }

    public function getTotalAchat(?Carbon $dateStart = null, ?Carbon $dateEnd = null): float
    {
        return $this->getQueryCached($dateStart, $dateEnd)->sum(function($item){
            return $item->price->getPriceAchat();
        });
    }

    public function getTotalMargeHT(?Carbon $dateStart = null, ?Carbon $dateEnd = null): float
    {
        return $this->getQueryCached($dateStart, $dateEnd)->sum(function($item){
            return $item->price->getMargeHT();
        });
    }

    public function getTotalAEncaisser(?Carbon $dateStart = null, ?Carbon $dateEnd = null): float
    {
        return $this->getQueryCached($dateStart, $dateEnd)->sum(function($item){
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

    public function getSalaireDiff(?\Illuminate\Support\Carbon $dateStart = null, ?\Illuminate\Support\Carbon $dateEnd = null): float
    {
        return $this->getQueryCached($dateStart, $dateEnd)->sum(function($item){
            return $item->price->getMargeHT() - $item->price->getMargeOriginHT();
        });
    }
}
