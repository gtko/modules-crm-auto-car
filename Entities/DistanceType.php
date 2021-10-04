<?php


namespace Modules\CrmAutoCar\Entities;


class DistanceType
{

    public function __construct(
        public string $origin_formatted,
        public string $destination_formatted,
        public string $distance_formatted,
        public string $duration_formatted,
        public int $distance_meter,
        public int $duration_second,

    ){}

    public function toArray(){
        return [
            "origin_formatted" => $this->origin_formatted,
            "destination_formatted" => $this->destination_formatted,
            "distance_formatted" => $this->distance_formatted,
            "duration_formatted" => $this->duration_formatted,
            "distance_meter" => $this->distance_meter,
            "duration_second" => $this->duration_second,
        ];
    }

}
