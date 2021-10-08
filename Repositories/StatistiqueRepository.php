<?php

namespace Modules\CrmAutoCar\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\BaseCore\Repositories\AbstractRepository;
use Modules\CrmAutoCar\Contracts\Repositories\StatistiqueRepositoryContract;

class StatistiqueRepository implements StatistiqueRepositoryContract
{


    public function getNombreLead(): float
    {
        // TODO: Implement getNombreLead() method.
    }

    public function getNombreFormulaire(): int
    {
        // TODO: Implement getNombreFormulaire() method.
    }

    public function getTauxConversion(): int
    {
        // TODO: Implement getTauxConversion() method.
    }

    public function getMargeMoyenne(): float
    {
        // TODO: Implement getMargeMoyenne() method.
    }

    public function getChiffreAffaireMoyenByClient(): float
    {
        // TODO: Implement getChiffreAffaireMoyenByClient() method.
    }
}
