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


    public function getNombreHeureByCommercial(): string
    {
        return mt_rand(1.00, 500.00);
    }

    public function getTauxHoraireByCommercial(): float
    {
        return mt_rand(8.00, 9.00);
    }

    public function getNombreContactByCommercial(): int
    {
        return mt_rand(9, 30);
    }

    public function getTauxConversionByCommercial(): int
    {
        return mt_rand(1.00, 500.00);
    }

    public function getMargeTtcByCommercial(): float
    {
        return mt_rand(1.00, 500.00);
    }

    public function getMargeNetByCommercial(): float
    {
        return mt_rand(1.00, 500.00);
    }

    public function getPanierMoyenTtcByCommercial(): float
    {
        return mt_rand(1.00, 500.00);
    }

    public function getPanierMoyenNetByCommercial(): float
    {
        return mt_rand(1.00, 500.00);
    }

    public function getMargeNetAfterHoraireByCommercial(): float
    {
        return mt_rand(1.00, 500.00);
    }

    public function getPanierMoyenNetAfterHoraire(): float
    {
        return mt_rand(1.00, 500.00);
    }

    public function getNombreContactTotal(): int
    {
        return mt_rand(1.00, 500.00);
    }

    public function getTauxConversionTotal(): float
    {
        return mt_rand(1.00, 500.00);
    }

    public function getMargeTtcTotal(): float
    {
        return mt_rand(1.00, 500.00);
    }

    public function getMargeNetTotal(): float
    {
        return mt_rand(1.00, 500.00);
    }

    public function getPannierMoyenTotal(): float
    {
        return mt_rand(1.00, 500.00);
    }
}
