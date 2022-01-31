<?php

namespace Modules\CrmAutoCar\Filters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Modules\CoreCRM\Contracts\Repositories\ClientRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Models\Commercial;

class ClientFilterQuery
{

    protected $repository;
    protected $query;

    public function __construct()
    {
        $this->repository = app(DossierRepositoryContract::class);
        $this->query = $this->repository->newQuery();
    }


    public function search($value){
        if($value) {
            foreach (explode(' ', $value) as $index => $lem) {
                $querySearch = $this->repository->searchQuery($this->repository->newQuery(), $lem);
                $this->query->where(function (Builder $query) use ($querySearch) {
                    $query->setQuery($querySearch->getQuery());
                });
            }
        }
    }

    public function byStatus($status = null){
        if($status){
            $this->query->where('status_id', $status);
        }
    }

    public function byCommercial($commercial = null){
        if($commercial){
            $this->query->where('commercial_id', $commercial);
        }
    }

    public function byTag($tag = null){
        if($tag){
            $this->query->whereHas('tags', function (Builder $query) use ($tag) {
                $query->where('tag_id', $tag);
            });
        }
    }

    public function byDateDepart($dateStart = null, $dateEnd = null){
        if($dateStart && $dateEnd){

            $dateStart = Carbon::parse($dateStart)->startOfDay();
            $dateEnd  = Carbon::parse($dateEnd)->endOfDay();

            $query = $this->query->with('devis')->get();
            $dossierIds = $query->filter(function ($item) use ($dateStart, $dateEnd) {
                $valide = false;
                foreach($item->devis as $devis) {
                    foreach(($devis->data['trajets'] ?? []) as $trajet){
                        if($trajet['aller_date_depart'] ?? false) {
                            $trajetDepart = Carbon::parse($trajet['aller_date_depart']);
                            if ($dateStart->lessThanOrEqualTo($trajetDepart) && $dateEnd->greaterThanOrEqualTo($trajetDepart)) {
                                $valide = true;
                            }
                        }
                    }
                }

                return $valide;
            })->pluck('id');

            $this->query->whereIn('id', $dossierIds);
        }
    }

    public function query(){
        return $this->query;
    }


}