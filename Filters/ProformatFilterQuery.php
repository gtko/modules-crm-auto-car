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

    public function paid(){
        //extract paid proformats
        $this->query->with('payments');
        $proformats = $this->query->get();
        $include = $proformats->filter(function ($proformat) {
            return $proformat->price->paid() === $proformat->price->getPriceTTC();
        })->pluck('id');
        $this->query->whereIn('id',$include);
    }

    public function notPaid(){
        //extract paid proformats
        $this->query->with('payments');
        $proformats = $this->query->get();
        $include = $proformats->filter(function ($proformat) {
            return $proformat->price->paid() !== $proformat->price->getPriceTTC();
        })->pluck('id');
        $this->query->whereIn('id',$include);
    }

    public function query(){
        return $this->query;
    }
}
