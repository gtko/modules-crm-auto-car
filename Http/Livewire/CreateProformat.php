<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CrmAutoCar\Contracts\Repositories\ProformatsRepositoryContract;
use Modules\DevisAutoCar\Entities\DevisPrice;

class CreateProformat extends Component
{
    public $devis;

    public function mount(DevisEntities $devis){
        $this->devis = $devis;
    }

    public function createProFormat(){
        $proformatRep = app(ProformatsRepositoryContract::class);
        if(!$this->devis->proformat()->exists()) {
            $next = $proformatRep->getNextNumber();
            $proformatRep->create($this->devis, $this->devis->getTotal(), $next);
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {

        return view('crmautocar::livewire.create-proformat');
    }
}
