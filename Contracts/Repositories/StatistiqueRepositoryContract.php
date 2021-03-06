<?php

namespace Modules\CrmAutoCar\Contracts\Repositories;

use Carbon\Carbon;
use Modules\BaseCore\Interfaces\RepositoryFetchable;
use Modules\CoreCRM\Models\Commercial;

interface StatistiqueRepositoryContract
{
    public function filterByBureau($bureauId);

    public function getNombreHeureByCommercial(Commercial $commercial,?Carbon $debut = null, ?Carbon $fin = null): string;
    public function getTauxHoraireByCommercial(Commercial $commercial,?Carbon $debut = null, ?Carbon $fin = null): float;
    public function getNombreLead(Commercial $commercial, Carbon|null $debut = null, Carbon|null $fin = null): int;
    public function getNombreContactByCommercial(Commercial $commercial,?Carbon $debut = null, ?Carbon $fin = null): int;
    public function getTauxConversionByCommercial(Commercial $commercial,?Carbon $debut = null, ?Carbon $fin = null): int;
    public function getMargeByCommercial(Commercial $commercial,?Carbon $debut = null, ?Carbon $fin = null): float;
    public function getMargeNetByCommercial(Commercial $commercial,?Carbon $debut = null, ?Carbon $fin = null): float;
    public function getPanierMoyenByCommercial(Commercial $commercial,?Carbon $debut = null, ?Carbon $fin = null): float;
    public function getPanierMoyenNetByCommercial(Commercial $commercial,?Carbon $debut = null, ?Carbon $fin = null): float;
    public function getMargeNetAfterHoraireByCommercial(Commercial $commercial,?Carbon $debut = null, ?Carbon $fin = null): float;
    public function getPanierMoyenNetAfterHoraire(Commercial $commercial,?Carbon $debut = null, ?Carbon $fin = null): float;

    public function getNombreLeadTotal(Carbon|null $debut = null, Carbon|null $fin = null): int;
    public function getNombreContactTotal(?Carbon $debut = null, ?Carbon $fin = null): int;
    public function getNombreContactWinTotal(?Carbon $debut = null, ?Carbon $fin = null): int;
    public function getTauxConversionTotal(?Carbon $debut = null, ?Carbon $fin = null): float;
    public function getMargeTotal(?Carbon $debut = null, ?Carbon $fin = null): float;
    public function getMargeNetTotal(?Carbon $debut = null, ?Carbon $fin = null): float;
    public function getPannierMoyenTotal(?Carbon $debut = null, ?Carbon $fin = null): float;
    public function getPannierNetTotal(?Carbon $debut = null, ?Carbon $fin = null): float;

}
