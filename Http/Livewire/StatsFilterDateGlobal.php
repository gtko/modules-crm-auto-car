<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\BaseCore\Actions\Dates\DateStringToCarbon;

class StatsFilterDateGlobal extends Component
{
    public $debut = '';
    public $fin = '';
    public $badge = '';




    public function clear()
    {
        $this->debut = null;
        $this->fin = null;
        $this->badge = '';
        $this->emit('resetCardGlobal', $this->debut, $this->fin);
    }

    public function filtre()
    {
        if ($this->debut && $this->fin) {
            $this->emit('dateRangeGlobal', $this->debut, $this->fin);
            $debut = (new DateStringToCarbon())->handle($this->debut);
            $fin = (new DateStringToCarbon())->handle($this->fin);
            $this->badge = 'du ' . $debut->format('d/m/Y') . ' au ' . $fin->format('d/m/Y');
        }
    }

    public function render()
    {
        return view('crmautocar::livewire.stats-filter-date-global');
    }
}
