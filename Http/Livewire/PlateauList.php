<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\BaseCore\Contracts\Repositories\UserRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\ClientRepositoryContract;

class PlateauList extends Component
{
    public $commercials;

    public function render(ClientRepositoryContract $repCommercial)
    {
        $this->commercials = $repCommercial->all();

        return view('crmautocar::livewire.plateau-list');
    }
}
