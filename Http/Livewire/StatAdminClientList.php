<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\BaseCore\Actions\Dates\DateStringToCarbon;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\CoreCRM\Models\Commercial;
use Modules\TimerCRM\Contracts\Repositories\TimerRepositoryContract;

class StatAdminClientList extends Component
{

    public $times;
    public $commercial;
    public $timeEdit = false;
    public $dateModif = '';
    public $idTime;

    public $start;
    public $end;

    protected $listeners = ['updateSelectCommercial', 'dateRange'];

    public function mount(){
        if(Auth::user()->hasRole('commercial')) {
            $this->commercial = Auth::commercial();
        }else{
            $this->commercial = app(CommercialRepositoryContract::class)->newQuery()->first();
        }

        $this->times = app(TimerRepositoryContract::class)->getTimeByPeriode($this->commercial, Carbon::now()->subYear(50), Carbon::now());

    }

    public function updateSelectCommercial(Commercial $commercial)
    {
        $this->commercial = $commercial;
        $this->times = app(TimerRepositoryContract::class)->getTimeByPeriode($this->commercial, Carbon::now()->subYear(50), Carbon::now());
    }

    public function dateRange($debut, $fin)
    {
        $this->start = $debut;
        $this->end = $fin;
    }

    public function editTime($id)
    {
        $this->idTime = $id;
        if($this->timeEdit)
        {
            $this->timeEdit = false;
            $this->dateModif = '';
        } else {
            $this->timeEdit = true;
        }
    }

    public function modifTime($id)
    {
        if($this->dateModif != '')
        {
            $repTime = app(TimerRepositoryContract::class);
            $time = $repTime->fetchById($id);
            $date = (new DateStringToCarbon())->handle($this->dateModif);
            $newCount = $time->start->diffInSeconds($this->dateModif);
            $repTime->modifTime($time, $newCount);

           $this->updateSelectCommercial($this->commercial);
           $this->timeEdit = false;
        }
    }



    public function render(CommercialRepositoryContract $repCommercial,)
    {
        if ($this->commercial) {
            $this->dossiers = $repCommercial->getClients($this->commercial);
        }

        if($this->start && $this->end) {
            $start = (new DateStringToCarbon())->handle($this->start);
            $fin = (new DateStringToCarbon())->handle($this->end);

            $this->times = app(TimerRepositoryContract::class)->getTimeByPeriode($this->commercial, $start, $fin);
        }else{
            $this->times = app(TimerRepositoryContract::class)->getTimeByPeriode($this->commercial, Carbon::now()->subYear(50), Carbon::now());
        }

        return view('crmautocar::livewire.stat-admin-client-list');
    }
}
