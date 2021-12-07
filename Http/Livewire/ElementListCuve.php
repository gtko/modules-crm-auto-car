<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Contracts\Services\FlowContract;
use Modules\CoreCRM\Models\Dossier;
use Modules\CoreCRM\Repositories\CommercialRepository;
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierAttribuer;

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
        $dossier = app(DossierRepositoryContract::class)->newQuery()->onlyTrashed()->find($id);
        $dossier->restore();
        $this->emit('refresh');
    }

    public function delete($id)
    {
        $dossier = app(DossierRepositoryContract::class)->fetchById($id);
        $dossier->delete();
        $this->cuveRefresh();
        $this->emit('refresh');
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

            app(FlowContract::class)->add(
                $this->dossier,
                (new ClientDossierAttribuer($this->dossier, $commercial, Auth::user()))
            );

            $this->emit('refresh');
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
