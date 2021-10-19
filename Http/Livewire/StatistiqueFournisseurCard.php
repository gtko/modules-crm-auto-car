<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Illuminate\Support\Collection;
use Livewire\Component;
use Modules\CrmAutoCar\Contracts\Repositories\DecaissementRepositoryContract;
use Modules\CrmAutoCar\Models\Decaissement;

class StatistiqueFournisseurCard extends Component
{
    public $resteARegler = 0;
    public $dejaRegler = 0;

    protected $listeners = [
        'updateCardTotal'
    ];

    public function updateCardTotal($value)
    {
        $repDecaissement = app(DecaissementRepositoryContract::class);
        $this->resteARegler = $repDecaissement->getTotalResteARegler($value);
        $this->dejaRegler = $repDecaissement->getTotalDejaRegler($value);
    }

    public function render()
    {
        return view('crmautocar::livewire.statistique-fournisseur-card');
    }
}
