<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\CrmAutoCar\Contracts\Repositories\DecaissementRepositoryContract;
use Modules\CrmAutoCar\Models\Decaissement;

class StatistiqueFournisseurPopupDetail extends Component
{

    public $decaissements;

    public function mount($decaissement_id)
    {

        $repDecaissement = app(DecaissementRepositoryContract::class);
        $decaissementModel = $repDecaissement->fetchById($decaissement_id);
        $this->decaissements = $repDecaissement->getDetailPaiement($decaissementModel);
    }

    public function render()
    {
        return view('crmautocar::livewire.statistique-fournisseur-popup-detail');
    }
}
