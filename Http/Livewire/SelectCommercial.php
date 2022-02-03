<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Auth;
use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Services\FlowCRM;
use Modules\CrmAutoCar\Contracts\Repositories\TagsRepositoryContract;
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierAttributionCommercial;

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
        $this->validate();
        $commercial = app(CommercialRepositoryContract::class)->fetchById($this->commercialSelect);
        app(DossierRepositoryContract::class)->changeCommercial($this->dossier, $commercial);
        (new FlowCRM())->add($this->dossier,new ClientDossierAttributionCommercial($this->dossier, $commercial, Auth::user(),));
        $this->emit('refresh');
        $this->emit('refreshTimeline');
    }


    public function render(TagsRepositoryContract $repTag)
    {

        $commercialAttribuer = $this->dossier->commercial;
        $commercialsList = app(CommercialRepositoryContract::class)->fetchAll();

        return view('crmautocar::livewire.select-commercial', [
            'commercialAttribuer' => $commercialAttribuer,
            'commercialsList' => $commercialsList
        ]);
    }
}
