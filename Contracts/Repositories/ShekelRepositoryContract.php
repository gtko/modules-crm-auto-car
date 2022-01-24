<?php

namespace Modules\CrmAutoCar\Contracts\Repositories;

use Modules\CrmAutoCar\Models\Shekel;

interface ShekelRepositoryContract
{
    public function create(float $price): Shekel;

    public function getPrice(): float;
}
