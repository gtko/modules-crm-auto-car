<?php

namespace Modules\CrmAutoCar\Services;

class FilterBureau
{
    public $activer = false;
    public $initial = false;

    public function activateFilter(){
        $this->initial = $this->activer;
        $this->activer = true;
    }

    public function desactivateFilter(){
        $this->initial = $this->activer;
        $this->activer = false;
    }

    public function resetInitial(){
        $this->activer = $this->initial;
    }

    public function isActived(){
        return $this->activer;
    }

}
