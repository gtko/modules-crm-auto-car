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
use Modules\CoreCRM\Contracts\Repositories\StatusRepositoryContract;
use Modules\CoreCRM\Models\Commercial;
use Modules\CoreCRM\Repositories\StatusRepository;
use Modules\CrmAutoCar\Contracts\Repositories\StatistiqueRepositoryContract;
use Modules\TimerCRM\Contracts\Repositories\TimerRepositoryContract;

class StatistiqueRepository implements StatistiqueRepositoryContract
{

    protected function getCollectionLeadByCommercial(Commercial $commercial, Carbon|null $debut = null, Carbon|null $fin = null){
        $repCommercial = app(CommercialRepositoryContract::class);

        if ($debut == null && $fin == null) {
            return $repCommercial->getDossiers($commercial);

        } else {
            return $repCommercial->getDossiers($commercial)
                ->where('created_at', '>=', $debut->startOfDay())
                ->where('created_at', '<=', $fin->endOfDay());
        }
    }

    public function getNombreLead(Commercial $commercial, Carbon|null $debut = null, Carbon|null $fin = null): int
    {
        return $this->getCollectionLeadByCommercial($commercial, $debut, $fin)->count();
    }

    public function getNombreLeadTotal(?Carbon $debut = null, ?Carbon $fin = null): int
    {
        $repCommercial = app(CommercialRepositoryContract::class);

        if ($debut == null && $fin == null) {
            $commercials = $repCommercial->fetchAll();
            $leadCount = 0;
            foreach ($commercials as $commercial) {
                $leadCount += $repCommercial->getDossiers($commercial)->count();
            }
        } else {
            $commercials = $repCommercial->fetchAll();
            $leadCount = 0;
            foreach ($commercials as $commercial) {
                $leadCount += $repCommercial->getDossiers($commercial)
                    ->where('created_at', '>=', $debut->startOfDay())
                    ->where('created_at', '<=', $fin->endOfDay())
                    ->count();
            }
        }

        return $leadCount;
    }


    public function getNombreHeureByCommercial(Commercial $commercial,?Carbon $debut = null, ?Carbon $fin = null): string
    {
        return app(TimerRepositoryContract::class)->getTotalTimeByCommercialPeriode($commercial, $debut, $fin);
    }

    public function getTauxHoraireByCommercial(Commercial $commercial,?Carbon $debut = null, ?Carbon $fin = null): float
    {
        return 9.86;
    }

    public function getNombreContactByCommercial(Commercial $commercial,?Carbon $debut = null, ?Carbon $fin = null): int
    {
        return $this->getCollectionLeadByCommercial($commercial, $debut, $fin)
            ->groupBy('client_id')->count();
    }

    public function getTauxConversionByCommercial(Commercial $commercial,?Carbon $debut = null, ?Carbon $fin = null): int
    {
        $dossier = $this->getCollectionLeadByCommercial($commercial, $debut, $fin)->pluck('id');
        $repository = app(DossierRepositoryContract::class);

        $dossierWin = $repository->newQuery()
            ->whereIn('id', $dossier)
            ->whereHas('status', function($q){
                    $status = app(StatusRepositoryContract::class)
                        ->fetchByType('win');
                    $q->whereIn('status_id',$status->pluck('id'));
            })->count();


        return ($dossierWin / $dossier->count()) * 100;
    }

    public function getMargeTtcByCommercial(Commercial $commercial,?Carbon $debut = null, ?Carbon $fin = null): float
    {
        return mt_rand(1.00, 500.00);
    }

    public function getMargeNetByCommercial(Commercial $commercial,?Carbon $debut = null, ?Carbon $fin = null): float
    {
        return mt_rand(1.00, 500.00);
    }

    public function getPanierMoyenTtcByCommercial(Commercial $commercial,?Carbon $debut = null, ?Carbon $fin = null): float
    {
        return mt_rand(1.00, 500.00);
    }

    public function getPanierMoyenNetByCommercial(Commercial $commercial,?Carbon $debut = null, ?Carbon $fin = null): float
    {
        return mt_rand(1.00, 500.00);
    }

    public function getMargeNetAfterHoraireByCommercial(Commercial $commercial,?Carbon $debut = null, ?Carbon $fin = null): float
    {
        return mt_rand(1.00, 500.00);
    }

    public function getPanierMoyenNetAfterHoraire(?Carbon $debut = null, ?Carbon $fin = null): float
    {
        return mt_rand(1.00, 500.00);
    }

    public function getNombreContactTotal(?Carbon $debut = null, ?Carbon $fin = null): int
    {
        return mt_rand(1.00, 500.00);
    }

    public function getTauxConversionTotal(?Carbon $debut = null, ?Carbon $fin = null): float
    {
        return mt_rand(1.00, 500.00);
    }

    public function getMargeTtcTotal(?Carbon $debut = null, ?Carbon $fin = null): float
    {
        return mt_rand(1.00, 500.00);
    }

    public function getMargeNetTotal(?Carbon $debut = null, ?Carbon $fin = null): float
    {
        return mt_rand(1.00, 500.00);
    }

    public function getPannierMoyenTotal(?Carbon $debut = null, ?Carbon $fin = null): float
    {
        return mt_rand(1.00, 500.00);
    }
}
