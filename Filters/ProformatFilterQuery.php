<?php

namespace Modules\CrmAutoCar\Filters;

use Carbon\Carbon;
use Modules\CoreCRM\Models\Commercial;
use Modules\CrmAutoCar\Contracts\Repositories\ProformatsRepositoryContract;

class ProformatFilterQuery
{

    public $repository;
    public $query;

    public function __construct(){
        $this->repository = app(ProformatsRepositoryContract::class);
        $this->query = $this->repository->newQuery();
    }

    public function byCommercial(?Commercial $commercial = null)
    {
        if($commercial){
            $this->query->hasCommercial($commercial);
        }
    }

    public function byCreatedAt(?Carbon $dateStart = null,?Carbon $dateEnd = null)
    {
        if($dateStart && $dateEnd){
            $this->query->whereBetween('created_at',[$dateStart,$dateEnd]);
        }
    }

    protected function getPaidIdsProformat(){
        $this->query->with('payments');
        $proformats = $this->query->get();
        return $proformats->filter(function ($proformat) {
            return $proformat->price->paid() === $proformat->price->getPriceTTC();
        })->pluck('id');
    }

    public function paid(){
        $this->query->whereIn('id',$this->getPaidIdsProformat());
    }

    public function notPaid(){
        $this->query->whereNotIn('id',$this->getPaidIdsProformat());
    }


    protected function getContactIdsProformat(){
        $this->query->with('payments');
        $proformats = $this->query->get();
        return $proformats->filter(function ($proformat) {
            return ($proformat->contactFournisseurs()->count() ?? 0) > 0;
        })->pluck('id');
    }

    public function contactChauffeur(){
        $this->query->whereIn('id',$this->getContactIdsProformat());
    }

    public function notContactChauffeur(){
        $this->query->whereNotIn('id',$this->getContactIdsProformat());
    }

    protected function getInfoVoyageIdsProformat(){
        $this->query->with('payments');
        $proformats = $this->query->get();
        return $proformats->filter(function ($proformat) {
            return ($proformat->devis->data['validated'] ?? false);
        })->pluck('id');
    }

    public function infoVoyage(){
        $this->query->whereIn('id',$this->getInfoVoyageIdsProformat());
    }

    public function notInfoVoyage(){
        $this->query->whereNotIn('id',$this->getInfoVoyageIdsProformat());
    }

    public function query(){
        return $this->query;
    }
}
