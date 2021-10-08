<?php

namespace Modules\CrmAutoCar\Contracts\Repositories;

use Modules\BaseCore\Interfaces\RepositoryFetchable;

interface StatistiqueRepositoryContract extends RepositoryFetchable
{
        public function getLeadByPeriode():float;
}
