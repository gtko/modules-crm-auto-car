<?php

namespace Modules\CrmAutoCar\Contracts\Repositories;

use Modules\BaseCore\Interfaces\RepositoryFetchable;

interface StatistiqueRepositoryContract
{
        public function getNombreLead(): float;
        public function getNombreFormulaire(): int;
        public function getTauxConversion(): int;
        public function getMargeMoyenne(): float;
        public function getChiffreAffaireMoyenByClient(): float;

}
