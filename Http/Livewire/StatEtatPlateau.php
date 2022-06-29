<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\CoreCRM\Models\Status;

class StatEtatPlateau extends Component
{
    public function render()
    {

        $status = Status::get();

        $select = [];
        foreach($status as $statu){
            $select[] =  DB::raw('(select count(id) from dossiers where status_id = '.$statu->id.' && commercial_id= users.id) as count_' . $statu->id);
        }


        $commercials = app(UserEntity::class)::whereHas('roles', function($query){
            $query->where('name', 'commercial');
        })
            ->with('personne')
            ->select('id','personne_id',
               ...$select
            )
            ->get();

        return view('crmautocar::livewire.stat-etat-plateau', compact('commercials', 'status'));
    }
}
