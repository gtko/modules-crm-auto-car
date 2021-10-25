<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\PlateauRepositoryContract;

class PlateauListDetailTag extends Component
{
    public function mount(PlateauRepositoryContract $repPlateau, CommercialRepositoryContract $repCommercial, $commercialId, $status)
    {
        $commercial = $repCommercial->fetchById($commercialId);
        $listTag = $repPlateau->filterTagByStatus($commercial, $status);
    }

    public function render()
    {
        return view('crmautocar::livewire.plateau-list-detail-tag');
    }
}
