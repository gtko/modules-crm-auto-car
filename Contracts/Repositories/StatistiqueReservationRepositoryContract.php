<?php

namespace Modules\CrmAutoCar\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Modules\BaseCore\Interfaces\RepositoryFetchable;
use Modules\BaseCore\Interfaces\RepositoryQueryCustom;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Models\Commercial;
use Modules\CrmAutoCar\Models\Proformat;
use Modules\SearchCRM\Interfaces\SearchableRepository;

interface StatistiqueReservationRepositoryContract extends RepositoryFetchable, RepositoryQueryCustom
{

    public function getTotalVente(?Carbon $dateStart = null, ?Carbon $dateEnd = null):float;
    public function getTotalAchat(?Carbon $dateStart = null, ?Carbon $dateEnd = null):float;

    public function getTotalMargeOriginHT(?Carbon $dateStart = null, ?Carbon $dateEnd = null):float;
    public function getTotalMargeHT(?Carbon $dateStart = null, ?Carbon $dateEnd = null):float;

    public function getTotalAEncaisser(?Carbon $dateStart = null, ?Carbon $dateEnd = null):float;
    public function getSalaireDiff(?Carbon $dateStart = null, ?Carbon $dateEnd = null):float;

    public function isBalanced():bool;

}
