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

    public $dateModifStart = '';
    public $dateModifEnd = '';

    public $idTime;
    public $addTime = false;
    public $showInputTime = false;

    public $modifDateStart;
    public $modifDateEnd;

    public $debut;
    public $fin;

    protected $rules = [
        'modifDateStart' => 'required',
        'modifDateEnd' => 'required',

    ];

    public function mount($filtre)
    {

        $this->debut = $filtre['debut'] ?? null;
        $this->fin = $filtre['fin'] ?? null;
        $this->bureau = $filtre['bureau'] ?? null;
        $this->commercial = $filtre['commercial'] ?? null;

        if($this->debut){
            $this->debut = \Illuminate\Support\Carbon::parse($this->debut);
        }

        if($this->fin){
            $this->fin = Carbon::parse($this->fin);
        }

        if($this->commercial){
            $this->commercial = app(CommercialRepositoryContract::class)->fetchById($this->commercial);
        }

        if(Auth::user()->isSuperAdmin()){
            $this->addTime = true;
        }

        $this->times = app(TimerRepositoryContract::class)->getTimeByPeriode($this->commercial, $this->debut, $this->fin);
    }

    public function addTime()
    {
        $this->validate();
        $start = (new DateStringToCarbon())->handle($this->modifDateStart);
        $fin = (new DateStringToCarbon())->handle($this->modifDateEnd);

        app(TimerRepositoryContract::class)->add($this->commercial, $start, $fin);

        $this->emit('refresh');
    }

    public function delete($id)
    {

        $timer = app(TimerRepositoryContract::class)->fetchById($id);
        app(TimerRepositoryContract::class)->delete($timer);

        $this->emit('refresh');
    }


    public function editTime($id)
    {
        $this->idTime = $id;
        $time = app(TimerRepositoryContract::class)->fetchById($id);

        $this->dateModifStart = $time->start->toDateTimeLocalString();
        $this->dateModifEnd = $time->start->clone()->addSeconds($time->count)->toDateTimeLocalString();

        if ($this->timeEdit) {
            $this->timeEdit = false;
            $this->dateModif = '';
            $this->dateModifEnd = '';
        } else {

            $this->timeEdit = true;

        }
    }

    public function modifTime($id)
    {
        if ($this->dateModifStart != '' && $this->dateModifEnd != '') {

            $start = (new DateStringToCarbon())->handle($this->dateModifStart);
            $end = (new DateStringToCarbon())->handle($this->dateModifEnd);

            $repTime = app(TimerRepositoryContract::class);
            $time = $repTime->fetchById($id);

            $repTime->modifTime($time, $start, $end);

            $this->timeEdit = false;
            $this->emit('refresh');
        }
    }


    public function render(CommercialRepositoryContract $repCommercial,)
    {
        if ($this->commercial) {
            $this->dossiers = $repCommercial->getClients($this->commercial);
        }

        if ($this->debut && $this->fin) {
            $this->times = app(TimerRepositoryContract::class)->getTimeByPeriode($this->commercial, $this->debut, $this->fin);
        } else {
            $this->times = app(TimerRepositoryContract::class)->getTimeByPeriode($this->commercial, Carbon::now()->subYear(50), Carbon::now());
        }

        return view('crmautocar::livewire.stat-admin-client-list');
    }
}
