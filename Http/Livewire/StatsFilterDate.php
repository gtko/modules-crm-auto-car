<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\BaseCore\Actions\Dates\DateStringToCarbon;
use Modules\CoreCRM\Models\Commercial;
use Modules\TimerCRM\Contracts\Repositories\TimerRepositoryContract;

class StatsFilterDate extends Component
{
    public $debut = '';
    public $fin = '';
    public $commercial;
    public $badge = '';

    protected $listeners = ['updateSelectCommercial'];

    public function mount(){
        if(Auth::user()->hasRole('commercial')) {
            $this->commercial = Auth::commercial();
        }
    }

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
