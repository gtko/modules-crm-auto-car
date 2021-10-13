<?php

namespace Modules\CrmAutoCar\Contracts\Repositories;

use Carbon\Carbon;
use Modules\BaseCore\Interfaces\RepositoryFetchable;
use Modules\CoreCRM\Models\Commercial;

interface StatistiqueRepositoryContract
{
    public function getNombreLead(Commercial $commercial, Carbon|null $debut = null, Carbon|null $fin = null): int;

    public function getTauxConversion(): float;

    public function getMargeMoyenne(): float;

    public function getChiffreAffaireMoyenByClient(): float;

    public function getNombreLeadTotal(Carbon|null $debut = null, Carbon|null $fin = null): int;

    public function getTauxConversionTotal(): float;

    public function getMargeMoyenneTotal(): float;

    public function getChiffreAffaireMoyenByClientTotal(): float;

}
