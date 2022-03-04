<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\BaseCore\Actions\Dates\DateStringToCarbon;
use Modules\CoreCRM\Contracts\Repositories\FournisseurRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\DecaissementRepositoryContract;

class StatistiqueFournisseurList extends Component
{
    public $decaissements;

    protected $listeners = ['filtre', 'updateList'];


    public function mount()
    {
        $this->updateList();
    }

    public function updateList() {
        $repDecaissement = app(DecaissementRepositoryContract::class);
        $this->decaissements = $repDecaissement->getByDevis();


    }

    public function filtre(DecaissementRepositoryContract $repDecaissement,FournisseurRepositoryContract $repFournisseur , $resteARegler, $fournisseur, $periodeStart, $periodeEnd, $dateDepart)
    {
        if($fournisseur !== ""){
            $fournisseur = $repFournisseur->fetchById($fournisseur);
        }

        if ($resteARegler == "oui") {
            $resteARegler = true;
        }
        elseif($resteARegler == 'troppayer'){
            $resteARegler = 'troppayer';
        }
        elseif ($resteARegler == "non") {
            $resteARegler = false;
        }

        if($periodeStart !== "" && $periodeEnd !== "")
        {
            $periodeStart = (new DateStringToCarbon())->handle($periodeStart);
            $periodeEnd = (new DateStringToCarbon())->handle($periodeEnd);
        }

        if($dateDepart !== "")
        {
            $dateDepart = (new DateStringToCarbon())->handle($dateDepart);
        }

       $this->decaissements =  $repDecaissement->getByFiltre($fournisseur, $resteARegler, $periodeStart, $periodeEnd, $dateDepart);

        $this->emit('updateCardTotal', $this->decaissements);
    }


    public function render()
    {

        return view('crmautocar::livewire.statistique-fournisseur-list');
    }
}
