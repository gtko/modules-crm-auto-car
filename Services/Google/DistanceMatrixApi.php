<?php


namespace Modules\CrmAutoCar\Services\Google;


use Illuminate\Support\Facades\Cache;
use Modules\CrmAutoCar\Contracts\Service\DistanceApiContract;
use Modules\CrmAutoCar\Entities\DistanceType;

class DistanceMatrixApi implements DistanceApiContract
{

    public function distance(string $origins, string $destinations): DistanceType
    {
        //@todo Mettre une clée environnement pour l'api key de google !!!
        $response = Cache::rememberForever("distance__cache__".md5($origins . $destinations).'v2',function() use ($origins, $destinations){
            return json_decode(file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?origins={$origins}&destinations={$destinations}&key=AIzaSyAlVEjfX9IfjTdKN3PoNy4-V-W4DqaRoz4"), true, 512, JSON_THROW_ON_ERROR);
        });

        return new DistanceType(
            $response['origin_addresses'][0],
            $response['destination_addresses'][0],
            $response['rows'][0]['elements'][0]['duration']['text'],
            $response['rows'][0]['elements'][0]['distance']['text'],
            $response['rows'][0]['elements'][0]['duration']['value'],
            $response['rows'][0]['elements'][0]['distance']['value'],
        );
    }
}
