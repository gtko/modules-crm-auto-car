<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Illuminate\Support\Collection;
use Livewire\Component;
use Modules\CrmAutoCar\Contracts\Repositories\DecaissementRepositoryContract;
use Modules\CrmAutoCar\Models\Decaissement;

class StatistiqueFournisseurCard extends Component
{
    public $totalARegler = 0;
    public $resteARegler = 0;
    public $dejaRegler = 0;

    protected $listeners = [
        'updateCardTotal'
    ];

    public function mount() {

        $repDecaissement = app(DecaissementRepositoryContract::class);
        $this->totalARegler = $repDecaissement->getTotalARegler();
        $this->resteARegler = $repDecaissement->getTotalResteARegler();
        $this->dejaRegler = $repDecaissement->getTotalDejaRegler();
    }

    public function updateCardTotal()
    {
        $repDecaissement = app(DecaissementRepositoryContract::class);
        $this->totalARegler = $repDecaissement->getTotalARegler();
        $this->resteARegler = $repDecaissement->getTotalResteARegler();
        $this->dejaRegler = $repDecaissement->getTotalDejaRegler();

    }

    public function render()
    {
        return view('crmautocar::livewire.statistique-fournisseur-card');
    }
}
