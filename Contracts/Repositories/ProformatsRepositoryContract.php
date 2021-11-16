<?php

namespace Modules\CrmAutoCar\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\BaseCore\Interfaces\RepositoryFetchable;
use Modules\BaseCore\Interfaces\RepositoryQueryCustom;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Models\Commercial;
use Modules\CrmAutoCar\Models\Proformat;
use Modules\SearchCRM\Interfaces\SearchableRepository;

interface ProformatsRepositoryContract extends SearchableRepository, RepositoryFetchable, RepositoryQueryCustom
{

    public function getNextNumber():string;

    public function create(DevisEntities $devis, float $total, string $number):Proformat;
    public function edit(Proformat $proformat, float $total):Proformat;
    public function updateNumber(Proformat $proformat,string $number):Proformat;
    public function searchByCommercialAndMonth(Commercial $comercial, int $mount): Collection;

}
