<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;

class StatsAdminListCommercial extends Component
{

    protected $commercials;
    public $commercial_id;

    public $filtreIn = [];

    public $queryString = ['commercial_id'];

    public function mount($filtre)
    {
        $this->filtreIn = $filtre;

        if(!$this->commercial_id) {
            if (!Auth::user()->hasRole(['super-admin', 'manager'])) {
                $this->commercial_id = Auth::user()->id;
            } else {
                $this->commercial_id = app(CommercialRepositoryContract::class)
                    ->newQuery()
                    ->role('commercial')
                    ->first()->id;
            }
        }
    }

    public function getKeyProperty(){
        return  md5(json_encode($this->filtre));
    }

    public function getFiltreProperty(){
        return array_merge($this->filtreIn, [
            'commercial' => $this->commercial_id,
            ]
        );
    }


    public function selectCommercial($commercialId)
    {
        $this->commercial_id = $commercialId;
    }

    public function render(CommercialRepositoryContract $repCommercial)
    {

        $this->commercials = $repCommercial
            ->newquery()
            ->where('enabled', true)
            ->role(['commercial', 'Résa', 'manager']);

            if($this->filtre['bureau']){
                $this->commercials->whereHas('roles', function (Builder $query){
                    $query->where('id', $this->filtre['bureau']);
                });
            }

        $this->commercials = $this->commercials->get()
                ->sortBy('format_name');

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
