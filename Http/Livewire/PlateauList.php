<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;

class PlateauList extends Component
{
    public $commercials;


    public function render(CommercialRepositoryContract $repCommercial)
    {
        $this->commercials = $repCommercial->all();

        return view('crmautocar::livewire.plateau-list');
    }
}

