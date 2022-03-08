<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;

class StatsAdminListCommercial extends Component
{

    protected $commercials;
    public $commercial_id;

    public function mount(CommercialRepositoryContract $repCommercial)
    {
        if(Auth::user()->hasRole('commercial')) {
            $this->commercial_id = Auth::user()->id;
        }else {
            $this->commercial_id = app(CommercialRepositoryContract::class)->newQuery()->first()->id;
        }

        $commercial = $repCommercial->fetchById($this->commercial_id);
        $this->emit('updateSelectCommercial', $commercial);
    }

    public function selectCommercial(CommercialRepositoryContract $repCommercial, $commercialId)
    {

        $this->commercial_id = $commercialId;
        $commercial = $repCommercial->fetchById($commercialId);
        $this->emit('updateSelectCommercial', $commercial);
    }

    public function render(CommercialRepositoryContract $repCommercial)
    {
            $this->commercials = $repCommercial->fetchAll();

        return view('crmautocar::livewire.stats-admin-list-commercial');
    }
}
