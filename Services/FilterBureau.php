<?php

namespace Modules\CrmAutoCar\Services;

class FilterBureau
{
    public $activer = true;

    public function activateFilter(){
        $this->activer = true;
    }

    public function desactivateFilter(){
        $this->activer = false;
    }

    public function isActived(){
        return $this->activer;
    }

}
