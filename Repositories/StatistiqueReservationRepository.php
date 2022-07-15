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
use Modules\CrmAutoCar\Models\Traits\EnumStatusCancel;
use Modules\CrmAutoCar\Models\Traits\EnumStatusDemandeFournisseur;

class StatistiqueReservationRepository extends AbstractRepository implements StatistiqueReservationRepositoryContract
{

    protected function getQueryCached(?Carbon $dateStart = null, ?Carbon $dateEnd = null, $keyForce = ""):Collection
    {
        $key = 'reservation_all';

        if($dateStart) {
            $key .= '_' . $dateStart->format('d-m-y-h-i-s');
        }

        if($dateEnd) {
            $key .= '_' . $dateEnd->format('d-m-y-h-i-s');
        }

        return Cache::driver('array')->remember($key . $keyForce, 1, function() use ($dateStart, $dateEnd){
            $query =  $this->newQuery()->with('payments', 'devis.dossier');
            if($dateStart && $dateEnd){
                $query->dateReservation($dateStart->startOfDay()->startOfMonth(), $dateEnd->endOfDay()->endOfMonth());
//                $query->whereBetween('created_at', [$dateStart->startOfDay()->startOfMonth(), $dateEnd->endOfDay()->endOfMonth()]);
            }

            return $query->has('devis')->get();
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

    public function getTotalMargeOriginHT(?\Illuminate\Support\Carbon $dateStart = null, ?\Illuminate\Support\Carbon $dateEnd = null): float
    {
        return $this->getQueryCached($dateStart, $dateEnd)->sum(function($item){
            return $item->price->getMargeOriginHT();
        });
    }

    public function getTotalMargeHT(?Carbon $dateStart = null, ?Carbon $dateEnd = null): float
    {
        return $this->getQueryCached($dateStart, $dateEnd)->sum(function($item) use ($dateEnd){
            return $item->price->getMargeHT($dateEnd);
        });
    }

    public function getTotalMargeHTDefinitive(?Carbon $dateStart = null, ?Carbon $dateEnd = null): float
    {
        return $this->getQueryCached($dateStart, $dateEnd)
            ->sum(function($item) use ($dateEnd){
                if($item->price->achatValidated()) {
                    return $item->price->getMargeHT($dateEnd);
                }

                return 0;
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

    public function getSalaireDiff($commercial = null, ?Carbon $dateStart = null, ?Carbon $dateEnd = null): float
    {
        $query =  $this->getModel()->query()->with('payments', 'devis.dossier');
        if($commercial) {
            $query->hasCommercial($commercial);
        }

        if($dateStart && $dateEnd){
            $query->dateReservation($dateStart->startOfDay()->startOfMonth(), $dateEnd->endOfDay()->endOfMonth());
        }

        $collect =  $query->has('devis')->get();


        return $collect->sum(function($item) use ($dateEnd){
            return $item->price->getSalaireDiff($dateEnd);
        });
    }


    public function isBalanced():bool
    {
        return Proformat::whereIn('status',[EnumStatusCancel::STATUS_CANCELED, EnumStatusCancel::STATUS_CANCELLER] )
            ->sum('total') === 0;
    }

}
