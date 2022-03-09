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
use Modules\CoreCRM\Enum\StatusTypeEnum;
use Modules\CoreCRM\Models\Commercial;
use Modules\CoreCRM\Repositories\StatusRepository;
use Modules\CrmAutoCar\Contracts\Repositories\ConfigsRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\ProformatsRepositoryContract;
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

        if($dossierWin === 0){
            return 0;
        }

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
       return $this->getNombreContactWinTotal($debut, $fin);
    }

    public function getNombreContactWinTotal(?Carbon $debut = null, ?Carbon $fin = null): int
    {
        $query = app(DossierRepositoryContract::class)->newQuery();
        if($debut && $fin) {
            $query->where('created_at', '>=', $debut->startOfDay())
                ->where('created_at', '<=', $fin->endOfDay());
        }

        $query->whereHas('devis', function($query){
            $query->has('proformat');
        });

        return $query->count();
    }

    public function getTauxConversionTotal(?Carbon $debut = null, ?Carbon $fin = null): float
    {
        return  ($this->getNombreContactWinTotal($debut, $fin) / $this->getNombreLeadTotal($debut, $fin)) * 100;
    }


    protected function getProformatPriceList(?Carbon $debut = null, ?Carbon $fin = null)
    {
        $rep = app(ProformatsRepositoryContract::class);
        $query = $rep->newQuery();
        $query->has('devis');
        if($debut && $fin) {
            $query->where('created_at', '>=', $debut->startOfDay())
                ->where('created_at', '<=', $fin->endOfDay());
        }

        return $query->get()->map(function($proformat){
            return $proformat->price;
        });
    }

    public function getMargeTtcTotal(?Carbon $debut = null, ?Carbon $fin = null): float
    {
        return $this->getProformatPriceList($debut, $fin)->sum(function($price) use ($fin){
            return $price->getMargeHT($fin) * (1 + ($price->getTauxTVA() / 100));
        });
    }

    public function getMargeNetTotal(?Carbon $debut = null, ?Carbon $fin = null): float
    {
        $margeTTC = $this->getMargeTtcTotal($debut, $fin);
        $repConfig = app(ConfigsRepositoryContract::class);
        $coutLead = $repConfig->getByName('price_lead')->data['price_lead'] ?? 0;

        return $margeTTC - ($this->getNombreLeadTotal($debut, $fin) * $coutLead);
    }

    public function getPannierMoyenTotal(?Carbon $debut = null, ?Carbon $fin = null): float
    {
        $totalLead = $this->getNombreContactWinTotal($debut, $fin);

        if($totalLead === 0){
            return 0;
        }

        return ($this->getMargeTtcTotal($debut, $fin)/ $totalLead);
    }

    public function getPannierNetTotal(?Carbon $debut = null, ?Carbon $fin = null): float
    {
        $totalLead = $this->getNombreContactWinTotal($debut, $fin);

        if($totalLead === 0){
            return 0;
        }

        return ($this->getMargeNetTotal($debut, $fin)/ $totalLead);
    }
}
