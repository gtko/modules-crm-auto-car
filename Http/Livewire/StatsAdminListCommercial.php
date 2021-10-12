<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;

class StatsAdminListCommercial extends Component
{

    protected $commercials;
    public $commercial_id;
    public $selected = false;

    public function selectCommercial(CommercialRepositoryContract $repCommercial, $commercialId)
    {
        $this->commercial_id = $commercialId;
        $this->selected = true;
        $commercial = $repCommercial->fetchById($commercialId);
        $this->emit('updateSelectCommercial', $commercial);
    }

    public function render(CommercialRepositoryContract $repCommercial)
    {
        $this->commercials = $repCommercial->fetchAll();

        return view('crmautocar::livewire.stats-admin-list-commercial');
    }
}
