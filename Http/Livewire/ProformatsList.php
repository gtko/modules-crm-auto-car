<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\CrmAutoCar\Contracts\Repositories\ProformatsRepositoryContract;

class ProformatsList extends Component
{

    public function mount()
    {

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render(ProformatsRepositoryContract $proformatRep)
    {
        $proformats = $proformatRep->fetchAll();

        return view('crmautocar::livewire.proformats-list', [
            'proformats' => $proformats
        ]);
    }
}
