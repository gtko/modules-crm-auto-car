<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\CoreCRM\Models\Commercial;

class StatsFilterDate extends Component
{
    public $debut;
    public $fin;
    public $commercial;

    protected $listeners = ['updateSelectCommercial'];

    public function updateSelectCommercial(Commercial $commercial)
    {
        $this->commercial = $commercial;

    }

    public function filtre()
    {
        $this->emit('dateRange', $this->debut, $this->fin, $this->commercial);
    }

    public function render()
    {
        return view('crmautocar::livewire.stats-filter-date');
    }
}
