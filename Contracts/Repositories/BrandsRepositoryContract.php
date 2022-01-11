<?php

namespace Modules\CrmAutoCar\Contracts\Repositories;

use Modules\BaseCore\Interfaces\RepositoryFetchable;
use Modules\BaseCore\Interfaces\RepositoryQueryCustom;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CrmAutoCar\Models\Brand;
use Modules\CrmAutoCar\Models\Invoice;
use Modules\SearchCRM\Interfaces\SearchableRepository;

interface BrandsRepositoryContract extends SearchableRepository, RepositoryFetchable, RepositoryQueryCustom
{

    public function getDefault($ttl = 60):Brand;


}
