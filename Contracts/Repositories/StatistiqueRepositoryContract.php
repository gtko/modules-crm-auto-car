<?php

namespace Modules\CrmAutoCar\Contracts\Repositories;

use Carbon\Carbon;
use Modules\BaseCore\Interfaces\RepositoryFetchable;
use Modules\CoreCRM\Models\Commercial;

interface StatistiqueRepositoryContract
{

    public function getNombreHeureByCommercial(): string;
    public function getTauxHoraireByCommercial(): float;
    public function getNombreLead(Commercial $commercial, Carbon|null $debut = null, Carbon|null $fin = null): int;
    public function getNombreContactByCommercial(): int;
    public function getTauxConversionByCommercial(): int;
    public function getMargeTtcByCommercial(): float;
    public function getMargeNetByCommercial(): float;
    public function getPanierMoyenTtcByCommercial(): float;
    public function getPanierMoyenNetByCommercial(): float;
    public function getMargeNetAfterHoraireByCommercial(): float;
    public function getPanierMoyenNetAfterHoraire(): float;

    public function getNombreLeadTotal(Carbon|null $debut = null, Carbon|null $fin = null): int;
    public function getNombreContactTotal(): int;
    public function getTauxConversionTotal(): float;
    public function getMargeTtcTotal(): float;
    public function getMargeNetTotal(): float;
    public function getPannierMoyenTotal(): float;

}
