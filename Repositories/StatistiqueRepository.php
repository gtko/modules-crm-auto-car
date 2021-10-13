<?php

namespace Modules\CrmAutoCar\Repositories;

use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\BaseCore\Repositories\AbstractRepository;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Models\Commercial;
use Modules\CrmAutoCar\Contracts\Repositories\StatistiqueRepositoryContract;

class StatistiqueRepository implements StatistiqueRepositoryContract
{


    public function getTauxConversion(): float
    {
        return mt_rand(1.00, 90.00);
    }

    public function getMargeMoyenne(): float
    {
        return mt_rand(100.00, 900.00);
    }

    public function getChiffreAffaireMoyenByClient(): float
    {
        return mt_rand(1000.00, 9000.00);
    }

    public function getNombreLead(Commercial $commercial, Carbon|null $debut = null, Carbon|null $fin = null): int
    {
        $repCommercial = app(CommercialRepositoryContract::class);

        if ($debut == null && $fin == null) {
            return $repCommercial->getDossiers($commercial)
                ->count();

        } else {
            return $repCommercial->getDossiers($commercial)
                ->where('created_at', '>=', $debut->startOfDay())
                ->where('created_at', '<=', $fin->endOfDay())
                ->count();
        }
    }

    public function getNombreLeadTotal(?Carbon $debut = null, ?Carbon $fin = null): int
    {
        $repCommercial = app(CommercialRepositoryContract::class);

        if ($debut == null && $fin == null) {
            $commercials = $repCommercial->fetchAll();
            $leadCount = 0;
            foreach ($commercials as $commercial) {
                $leadCount = $leadCount + $repCommercial->getDossiers($commercial)->count();
            }
        } else {
            $commercials = $repCommercial->fetchAll();
            $leadCount = 0;
            foreach ($commercials as $commercial) {
                $leadCount = $leadCount + $repCommercial->getDossiers($commercial)
                        ->where('created_at', '>=', $debut->startOfDay())
                        ->where('created_at', '<=', $fin->endOfDay())
                        ->count();
            }
        }

        return $leadCount;

    }

    public function getTauxConversionTotal(): float
    {
        return mt_rand(10.00, 100.00);
    }

    public function getMargeMoyenneTotal(): float
    {
        return mt_rand(1000.00, 9000.00);
    }

    public function getChiffreAffaireMoyenByClientTotal(): float
    {
        return mt_rand(1000.00, 9000.00);
    }
}
