<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\CrmAutoCar\Contracts\Repositories\DecaissementRepositoryContract;
use Modules\CrmAutoCar\Models\Decaissement;

class StatistiqueFournisseurCountNombrePaiement extends Component
{
    public $count;
    public $decaissement;

    public function mount($decaissement)
    {
        $repDecaissement = app(DecaissementRepositoryContract::class);
        $this->count = $repDecaissement->getCountNombrePaiement($decaissement);
    }

    public function detail($decaissementId)
    {
        $this->emit('popup-detail-paiement:open', ['decaissement_id' =>  $decaissementId]);
    }

    public function render()
    {
        return view('crmautocar::livewire.statistique-fournisseur-count-nombre-paiement');
    }
}
