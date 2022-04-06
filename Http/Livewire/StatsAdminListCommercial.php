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
        if(!Auth::user()->hasRole(['super-admin', 'manager'])){
            $this->commercial_id = Auth::user()->id;
        }else {
            $this->commercial_id = app(CommercialRepositoryContract::class)
                    ->newQuery()
                    ->role('commercial')
                    ->first()->id;
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
        $this->commercials = $repCommercial->newquery()->role(['commercial', 'Résa', 'manager'])->get();

        $users = [
            'commerciaux' => [],
            'resas' => [],
            'managers' => [],
        ];

        foreach($this->commercials as $commercial){
            if($commercial->hasRole('commercial')){
                $users['commerciaux'][] = $commercial;
            }

            if($commercial->hasRole('Résa')){
                $users['resas'][] = $commercial;
            }

            if($commercial->hasRole('manager')){
                $users['managers'][] = $commercial;
            }
        }

        return view('crmautocar::livewire.stats-admin-list-commercial', compact('users'));
    }
}
