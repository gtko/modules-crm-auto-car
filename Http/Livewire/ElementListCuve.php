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
    public $filtre;

    protected $listeners = [
        'listcuve:attribuer' => 'attribuer',
        'cuveRefresh',
        'allSelect'
    ];

    public function allSelect($value)
    {
        if (!$value) {
            $this->selection = false;
        } else {
            $this->selection = true;
        }
    }

    public function restore($id)
    {
        $dossier = app(DossierRepositoryContract::class)->fetchById($id);
        $dossier->restore();
        $this->emit('refresh');
    }

    public function delete($id)
    {
        $dossier = app(DossierRepositoryContract::class)->fetchById($id);
        $dossier->delete();
        $this->cuveRefresh();
    }

    public function cuveRefresh()
    {
        $this->selection = false;
    }

    public function attribuer($commercial_id)
    {

        if ($this->selection) {
            $commercial = app(CommercialRepositoryContract::class)->fetchById($commercial_id);
            app(DossierRepositoryContract::class)->changeCommercial($this->dossier, $commercial);
        }
    }


    public function mount(Dossier $dossier, $filtre)
    {
        $this->dossier = $dossier;
        $this->filtre = $filtre;
    }

    public function render()
    {
        return view('crmautocar::livewire.element-list-cuve');
    }
}
