<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\FournisseurRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\DecaissementRepositoryContract;

class StatistiqueFournisseurFiltre extends Component
{
    public $fournisseursFiltre = "";
    public $fournisseursList = "";
    public $resteARegler = "";
    public $periodeStart = "";
    public $periodeEnd = "";
    public $dateDepart = "";

    public function mount(FournisseurRepositoryContract $repFournisseur)
    {
        $this->fournisseursList = $repFournisseur->getAllList();
    }


    public function updatedResteARegler()
    {
        $this->filtre();
    }

    public function updatedFournisseursFiltre()
    {
        $this->filtre();
    }

    public function updatedPeriodeStart()
    {
        $this->filtre();
    }

    public function updatedPeriodeEnd()
    {
        $this->filtre();
    }

    public function updatedDateDepart()
    {
        $this->filtre();
    }

    public function filtre()
    {
        $this->emit('filtre', $this->resteARegler, $this->fournisseursFiltre, $this->periodeStart, $this->periodeEnd, $this->dateDepart);
    }

    public function clear()
    {
        $this->periodeEnd = "";
        $this->periodeStart = "";
        $this->dateDepart = "";
        $this->resteARegler = "";
        $this->fournisseursFiltre = "";

        $this->filtre();
        $this->emit('updateList');
    }

    public
    function render()
    {
        return view('crmautocar::livewire.statistique-fournisseur-filtre');
    }
}
