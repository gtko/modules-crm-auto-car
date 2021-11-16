<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\ProformatsRepositoryContract;

class ProformatsList extends Component
{

    public $mois;
    public $commercialSelect;
    public $commercial;

    public function mount()
    {

    }

    public function updatedMois()
    {
        $this->filtre();
    }

    public function updatedCommercialSelect()
    {

        $this->filtre();

    }

    public function filtre()
    {
        $repCommercial = app(CommercialRepositoryContract::class);
        $repProformat = app(ProformatsRepositoryContract::class);

        $this->commercial = $repCommercial->fetchById($this->commercialSelect);


    }

    public function render(ProformatsRepositoryContract $proformatRep, CommercialRepositoryContract $repcommercial): Factory|View|Application
    {
        $commercials = $repcommercial->fetchAll();
        $proformats = $proformatRep->fetchAll();

        return view('crmautocar::livewire.proformats-list', [
            'proformats' => $proformats,
            'commercials' => $commercials
        ]);
    }
}
