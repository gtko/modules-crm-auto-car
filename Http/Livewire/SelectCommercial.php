<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Services\FlowCRM;
use Modules\CrmAutoCar\Contracts\Repositories\TagsRepositoryContract;
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierAttributionCommercial;
use Modules\CrmAutoCar\Models\Proformat;

class SelectCommercial extends Component
{
    public $dossier;
    public $commercialSelect;


    public $listeners = ['refresh' => '$refresh'];

    protected $rules = [
        'commercialSelect' => 'required'
    ];

    public function mount($client, $dossier)
    {
        $this->dossier = $dossier;
        $this->commercialSelect = $this->dossier->commercial->id;
    }

    public function changerCommercial()
    {
        if (\Illuminate\Support\Facades\Auth::user()->can('changeCommercial', Proformat::class))
        {
            $this->validate();
            $commercial = app(CommercialRepositoryContract::class)->fetchById($this->commercialSelect);
            app(DossierRepositoryContract::class)->changeCommercial($this->dossier, $commercial);
            (new FlowCRM())->add($this->dossier, new ClientDossierAttributionCommercial($this->dossier, $commercial, Auth::user(),));
            $this->emit('refresh');
            $this->emit('refreshTimeline');
        }
    }


    public function render(TagsRepositoryContract $repTag)
    {

        $commercialAttribuer = $this->dossier->commercial;
        $commercialsList = app(CommercialRepositoryContract::class)->newquery()->role('commercial')->get();

        return view('crmautocar::livewire.select-commercial', [
            'commercialAttribuer' => $commercialAttribuer,
            'commercialsList' => $commercialsList
        ]);
    }
}
