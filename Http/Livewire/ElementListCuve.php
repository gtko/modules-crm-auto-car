<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Models\Dossier;
use Modules\CoreCRM\Repositories\CommercialRepository;

class ElementListCuve extends Component
{
    public $dossier;
    public $selection = false;


    protected $listeners = ['listcuve:attribuer' => 'attribuer'];

    public function attribuer($commercial_id){

        if($this->selection){
            //@todo attribuer le commercial au dossier
            $commercial  = app(CommercialRepositoryContract::class)->fetchById($commercial_id);
            app(DossierRepositoryContract::class)->changeCommercial($this->dossier, $commercial);
        }

    }


    public function mount(Dossier $dossier)
    {
        $this->dossier = $dossier;
    }

    public function render()
    {
        return view('crmautocar::livewire.element-list-cuve');
    }
}
