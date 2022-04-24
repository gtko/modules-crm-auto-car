<?php


namespace Modules\CrmAutoCar\Services\Google;


use Illuminate\Support\Facades\Cache;
use Modules\CrmAutoCar\Contracts\Service\DistanceApiContract;
use Modules\CrmAutoCar\Entities\DistanceType;

class DistanceMatrixApi implements DistanceApiContract
{


    protected function getAddressComponents($addressComponents, $type){
        return collect($addressComponents ?? [])
            ->filter(function ($item) use ($type){
                return in_array($type, $item['types']);
            })
            ->map(function($item) {
                return $item['long_name'];
            })->first();
    }

    public function distance(string $origins, string $destinations, string $originFormat = null, string $destinationFormat = null): DistanceType
    {
        //@todo Mettre une clée environnement pour l'api key de google !!!
        $response = Cache::rememberForever("distance__cache__".md5($origins . $destinations).'v2',function() use ($origins, $destinations){
            return json_decode(file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?origins={$origins}&destinations={$destinations}&key=AIzaSyAlVEjfX9IfjTdKN3PoNy4-V-W4DqaRoz4"), true, 512, JSON_THROW_ON_ERROR);
        });

        $responseInfo = Cache::rememberForever("info_google__cache__".md5($origins . $destinations).'v3',function() use ($origins, $destinations){
            return [
                'origin' => json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address={$origins}&key=AIzaSyAlVEjfX9IfjTdKN3PoNy4-V-W4DqaRoz4"), true, 512, JSON_THROW_ON_ERROR),
                'destination' => json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address={$destinations}&key=AIzaSyAlVEjfX9IfjTdKN3PoNy4-V-W4DqaRoz4"), true, 512, JSON_THROW_ON_ERROR)
            ];
        });


        $codePostalOrigin = $this->getAddressComponents($responseInfo['origin']['results'][0]['address_components'] ?? [], 'postal_code');
        $villeOrigin = $this->getAddressComponents($responseInfo['origin']['results'][0]['address_components'] ?? [], 'locality');
        $countryOrigin = $this->getAddressComponents($responseInfo['origin']['results'][0]['address_components'] ?? [], 'country');

        $codePostalDestination = $this->getAddressComponents($responseInfo['destination']['results'][0]['address_components'] ?? [], 'postal_code');
        $villeDestination = $this->getAddressComponents($responseInfo['destination']['results'][0]['address_components'] ?? [], 'locality');
        $countryDestination = $this->getAddressComponents($responseInfo['destination']['results'][0]['address_components'] ?? [], 'country');

        $originFormat = $villeOrigin . ', ' . $codePostalOrigin . ', ' . $countryOrigin;
        $destinationFormat = $villeDestination . ', ' . $codePostalDestination . ', ' . $countryDestination;

        return new DistanceType(
            ($originFormat ?? $response['origin_addresses'][0]),
            ($destinationFormat ?? $response['destination_addresses'][0]),
            $response['rows'][0]['elements'][0]['duration']['text'],
            $response['rows'][0]['elements'][0]['distance']['text'],
            $response['rows'][0]['elements'][0]['duration']['value'],
            $response['rows'][0]['elements'][0]['distance']['value'],
        );
    }
}
