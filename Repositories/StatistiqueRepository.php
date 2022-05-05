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
use Modules\CrmAutoCar\Contracts\Repositories\ShekelRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\StatistiqueRepositoryContract;
use Modules\TimerCRM\Contracts\Repositories\TimerRepositoryContract;

class StatistiqueRepository implements StatistiqueRepositoryContract
{

    public $commercialRepository;
    public $dossierRepository;
    public $proformaRepository;


    public function __construct(
        CommercialRepositoryContract $commercialRepository,
        DossierRepositoryContract $dossierRepository,
        ProformatsRepositoryContract $proformaRepository
    )
    {
        $this->commercialRepository = $commercialRepository;
        $this->dossierRepository = $dossierRepository;
        $this->proformaRepository = $proformaRepository;



        $this->commercialRepository->setQuery(
            $this->commercialRepository->newQuery()->where('id', '!=', 1)
        );

    }

    public function filterByBureau($bureauId){
        if($bureauId){
            $this->commercialRepository->setQuery(
                $this->commercialRepository->newQuery()
                ->where('id', '!=', 1)
                ->whereHas('roles', function (Builder $query) use ($bureauId) {
                    $query->where('id', $bureauId);
                })
            );

            $this->dossierRepository->setQuery(
                $this->dossierRepository->newQuery()
                    ->whereHas('commercial', function (Builder $query) use ($bureauId) {
                        $query->where('id', '!=', 1);
                        $query->whereHas('roles', function (Builder $query) use ($bureauId) {
                            $query->where('id', $bureauId);
                        });
                    })
            );

            $this->proformaRepository->setQuery(
                $this->proformaRepository->newQuery()
                    ->whereHas('devis', function (Builder $query) use ($bureauId) {
                        $query->whereHas('dossier', function (Builder $query) use ($bureauId) {
                            $query->whereHas('commercial', function (Builder $query) use ($bureauId) {
                                $query->where('id', '!=', 1);
                                $query->whereHas('roles', function (Builder $query) use ($bureauId) {
                                    $query->where('id', $bureauId);
                                });
                            });
                        });
                    })
            );
        }
    }

    protected function getCollectionLeadByCommercial(Commercial $commercial, Carbon|null $debut = null, Carbon|null $fin = null){
        $repCommercial =  $this->commercialRepository;

        if ($debut == null && $fin == null) {
            return $this->dossierRepository->getDossiersByCommercial($commercial)->get();

        } else {
            return $this->dossierRepository->getDossiersByCommercial($commercial)
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
        $repCommercial = $this->commercialRepository;

        if ($debut == null || $fin == null) {
            $commercials = $repCommercial->fetchAll();
            $leadCount = 0;
            foreach ($commercials as $commercial) {
                $leadCount += $this->dossierRepository->getDossiersByCommercial($commercial)->count();
            }
        } else {
            $commercials = $repCommercial->fetchAll();
            $leadCount = 0;
            foreach ($commercials as $commercial) {
                $leadCount += $this->dossierRepository->getDossiersByCommercial($commercial)
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

    protected function getNombreHeure(Commercial $commercial,?Carbon $debut = null, ?Carbon $fin = null): string
    {
        return app(TimerRepositoryContract::class)->getTimeByPeriode($commercial, $debut, $fin)->sum('count') / 3600;
    }


    public function getTauxHoraireByCommercial(Commercial $commercial,?Carbon $debut = null, ?Carbon $fin = null): float
    {
        return 35 * app(ShekelRepositoryContract::class)->getPrice();
    }

    public function getNombreContactByCommercial(Commercial $commercial,?Carbon $debut = null, ?Carbon $fin = null): int
    {
        $repository = $this->dossierRepository;
        $query = $repository->newQuery()
            ->where('commercial_id', $commercial->id)
            ->whereHas('devis', function($q){
                $q->has('proformat');
            });

        if($debut && $fin){
            $query->whereBetween('created_at', [$debut->startOfDay(),$fin->endOfDay()]);
        }

        return $query->count();
    }

    public function getTauxConversionByCommercial(Commercial $commercial,?Carbon $debut = null, ?Carbon $fin = null): int
    {
        $dossier = $this->getCollectionLeadByCommercial($commercial, $debut, $fin)->pluck('id');
        $dossierWin = $this->getNombreContactByCommercial($commercial, $debut, $fin);

        if($dossierWin === 0){
            return 0;
        }


        return ($dossierWin / $dossier->count()) * 100;
    }

    public function getMargeByCommercial(Commercial $commercial,?Carbon $debut = null, ?Carbon $fin = null): float
    {
        return $this->getProformatPriceList($debut, $fin, $commercial)->sum(function($price) use ($fin){
            return $price->getMargeHT($fin);
        });
    }

    public function getMargeNetByCommercial(Commercial $commercial,?Carbon $debut = null, ?Carbon $fin = null): float
    {
        return $this->getProformatPriceList($debut, $fin, $commercial)->sum(function($price) use ($fin){
            return $price->getMargeHT($fin);
        }) - ($this->getNombreLead($commercial, $debut, $fin) * $this->getCoutLead());
    }

    protected function getCoutLead(){
        $repConfig = app(ConfigsRepositoryContract::class);

        return $repConfig->getByName('price_lead')->data['price_lead'] ?? 0;
    }

    public function getPanierMoyenByCommercial(Commercial $commercial,?Carbon $debut = null, ?Carbon $fin = null): float
    {
        $contrat = $this->getNombreContactByCommercial($commercial, $debut, $fin);
        if($contrat === 0){
            return 0;
        }

        return $this->getMargeByCommercial($commercial, $debut, $fin) / $contrat;
    }

    public function getPanierMoyenNetByCommercial(Commercial $commercial,?Carbon $debut = null, ?Carbon $fin = null): float
    {
        $contrat = $this->getNombreContactByCommercial($commercial, $debut, $fin);
        if($contrat === 0){
            return 0;
        }

        return $this->getMargeNetByCommercial($commercial, $debut, $fin) / $contrat;
    }

    public function getMargeNetAfterHoraireByCommercial(Commercial $commercial,?Carbon $debut = null, ?Carbon $fin = null): float
    {
        return $this->getMargeNetByCommercial($commercial, $debut, $fin) - ($this->getNombreHeure($commercial, $debut, $fin) * $this->getTauxHoraireByCommercial($commercial, $debut, $fin));
    }

    public function getPanierMoyenNetAfterHoraire(Commercial $commercial, ?Carbon $debut = null, ?Carbon $fin = null): float
    {
        $contrat = $this->getNombreContactByCommercial($commercial, $debut, $fin);
        if($contrat === 0){
            return 0;
        }

        return $this->getMargeNetAfterHoraireByCommercial($commercial, $debut, $fin) / $contrat;
    }

    public function getNombreContactTotal(?Carbon $debut = null, ?Carbon $fin = null): int
    {
       return $this->getNombreContactWinTotal($debut, $fin);
    }

    public function getNombreContactWinTotal(?Carbon $debut = null, ?Carbon $fin = null): int
    {
        $query = $this->dossierRepository->newQuery();
        if($debut && $fin) {
            $query->where('created_at', '>=', $debut->startOfDay())
                ->where('created_at', '<=', $fin->endOfDay());
        }

        $query->whereHas('devis', function($query){
            $query->has('proformat');
        });

//        dd($query->count());

        return $query->count();
    }

    public function getTauxConversionTotal(?Carbon $debut = null, ?Carbon $fin = null): float
    {
        $totalLead = $this->getNombreLeadTotal($debut, $fin);
        if($totalLead === 0){
            return 0;
        }

        return ($this->getNombreContactWinTotal($debut, $fin) / $totalLead) * 100;
    }


    protected function getProformatPriceList(?Carbon $debut = null, ?Carbon $fin = null, $commercial = null)
    {
        $rep = $this->proformaRepository;
        $query = $rep->newQuery();
        $query->has('devis');

        if($commercial){
            $query->whereHas('devis', function($query) use ($commercial){
                $query->whereHas('dossier', function($query) use ($commercial){
                    $query->where('commercial_id', $commercial->id);
                });
            });
        }

        if($debut && $fin) {
            $query->where('created_at', '>=', $debut->startOfDay())
                ->where('created_at', '<=', $fin->endOfDay());
        }

        return $query->get()->map(function($proformat){
            return $proformat->price;
        });
    }

    public function getMargeTotal(?Carbon $debut = null, ?Carbon $fin = null): float
    {
        return $this->getProformatPriceList($debut, $fin)->sum(function($price) use ($fin){
            return $price->getMargeHT($fin);
        });
    }

    public function getMargeNetTotal(?Carbon $debut = null, ?Carbon $fin = null): float
    {
        $marge = $this->getMargeTotal($debut, $fin);


        return $marge - ($this->getNombreLeadTotal($debut, $fin) * $this->getCoutLead());
    }

    public function getPannierMoyenTotal(?Carbon $debut = null, ?Carbon $fin = null): float
    {
        $totalLead = $this->getNombreContactWinTotal($debut, $fin);

        if($totalLead === 0){
            return 0;
        }

        return ($this->getMargeTotal($debut, $fin)/ $totalLead);
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
