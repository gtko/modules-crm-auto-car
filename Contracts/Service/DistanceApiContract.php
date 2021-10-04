<?php


namespace Modules\CrmAutoCar\Contracts\Service;



use Modules\CrmAutoCar\Entities\DistanceType;

interface DistanceApiContract
{

    /**
     * @param string $origins Lat, Lng
     * @param string $destinations Lat, Lng
     */
    public function distance(string $origins, string $destinations):DistanceType;

}
