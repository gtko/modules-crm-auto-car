<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\BaseCore\Actions\Dates\DateStringToCarbon;
use Modules\CoreCRM\Models\Commercial;

class StatsFilterDate extends Component
{
    public $debut = '';
    public $fin = '';
    public $commercial;
    public $badge = '';

    protected $listeners = ['updateSelectCommercial'];

    public function updateSelectCommercial(Commercial $commercial)
    {
        $this->commercial = $commercial;

    }

    public function clear()
    {
        $this->debut = null;
        $this->fin = null;
        $this->badge = '';
        $this->emit('resetCard', $this->commercial, $this->debut, $this->fin);
    }

    public function filtre()
    {
        if ($this->debut && $this->fin && $this->commercial) {
            $this->emit('dateRange', $this->debut, $this->fin, $this->commercial);
            $debut = (new DateStringToCarbon())->handle($this->debut);
            $fin = (new DateStringToCarbon())->handle($this->fin);
            $this->badge = 'du ' . $debut->format('d/m/Y') . ' au ' . $fin->format('d/m/Y');
        }
    }

    public function render()
    {
        return view('crmautocar::livewire.stats-filter-date');
    }
}
