<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\PlateauRepositoryContract;

class PlateauListDetail extends Component
{

    public $commercial_id;


    public function mount($commercialId)
    {
        $this->commercial_id = $commercialId;

    }

    public function render(CommercialRepositoryContract $repCommercial, PlateauRepositoryContract $repPlateau)
    {
        $commercialByStatus = collect();
        $modelCommercial = $repCommercial->fetchById($this->commercial_id);
        $commercialByStatus = $repPlateau->filterByStatus($modelCommercial);
//        $commercialByTags = $repPlateau->filterByTags($modelCommercial);


        return view('crmautocar::livewire.plateau-list-detail', compact(['commercialByStatus', 'modelCommercial']));
    }
}
