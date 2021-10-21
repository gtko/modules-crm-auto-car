<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\CoreCRM\Models\Commercial;
use Modules\CrmAutoCar\Contracts\Repositories\PlateauRepositoryContract;

class PlateauListDetail extends Component
{
    public $commercial;

    public function mount(CommercialRepositoryContract $repCommercial, PlateauRepositoryContract $repPlateau, $commercialId)
    {
        $this->commercial = $repCommercial->fetchById($commercialId);
        $commercialByStatus = $repPlateau->
    }

    public function render()
    {
        return view('crmautocar::livewire.plateau-list-detail');
    }
}
