<?php

namespace Modules\CrmAutoCar\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\BaseCore\Repositories\AbstractRepository;
use Modules\CrmAutoCar\Contracts\Repositories\ShekelRepositoryContract;
use Modules\CrmAutoCar\Models\Shekel;

class ShekelRepositories implements ShekelRepositoryContract
{

    public function create(float $price): Shekel
    {
        $shekel = new Shekel();
        $shekel->shekel = $price;
        $shekel->save();

        return $shekel;
    }


    public function getPrice(): float
    {
        $shekels = Shekel::all();
        return $shekels->last()->shekel ?? 0;
    }
}
