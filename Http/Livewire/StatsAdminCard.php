<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\BaseCore\Actions\Dates\DateStringToCarbon;
use Modules\CoreCRM\Models\Commercial;
use Modules\CrmAutoCar\Contracts\Repositories\StatistiqueRepositoryContract;
use Modules\TimerCRM\Contracts\Repositories\TimerRepositoryContract;

class StatsAdminCard extends Component
{
    public $nombreLeads = 0;
    public $tauxConversion = 0;
    public $margeMoyenne = 0;
    public $chiffreAffaireMoyenClient = 0;
    public $nombreFormulaire = 0;
    public $totalTemps = '0';

    public $commercial;
    public $debut;
    public $fin;

    protected $listeners = ['updateSelectCommercial', 'dateRange', 'resetCard'];

    public function updateSelectCommercial(Commercial $commercial)
    {
        $this->commercial = $commercial;
    }

    public function resetCard(Commercial $commercial, $debut, $fin)
    {
        $this->commercial = $commercial;
        $this->debut = $debut;
        $this->fin = $fin;
    }

    public function dateRange($debut, $fin, Commercial $commercial)
    {
        $this->commercial = $commercial;

        if($debut && $fin)
        {
            $this->debut =( new DateStringToCarbon())->handle($debut);
            $this->fin =( new DateStringToCarbon())->handle($fin);
        }
    }

    public function render(StatistiqueRepositoryContract $repStat, TimerRepositoryContract $repTimer)
    {
        if ($this->commercial) {
            $this->nombreLeads = $repStat->getNombreLead($this->commercial, $this->debut, $this->fin);
            $this->tauxConversion = $repStat->getTauxConversion();
            $this->margeMoyenne = $repStat->getMargeMoyenne();
            $this->chiffreAffaireMoyenClient = $repStat->getChiffreAffaireMoyenByClient();
            $this->totalTemps = $repTimer->getTotalTimeByCommercialPeriode($this->commercial, $this->debut, $this->fin);
        }

        return view('crmautocar::livewire.stats-admin-card');
    }
}
