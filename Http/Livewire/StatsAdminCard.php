<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\BaseCore\Actions\Dates\DateStringToCarbon;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\CoreCRM\Models\Commercial;
use Modules\CrmAutoCar\Contracts\Repositories\StatistiqueRepositoryContract;
use Modules\TimerCRM\Contracts\Repositories\TimerRepositoryContract;

class StatsAdminCard extends Component
{
    public $nombeHeureTravail = 0;
    public $tauxHoraire = 0;
    public $nombreLead = 0;
    public $nombreContrat = 0;
    public $tauxConversion = 0;
    public $margeTtc = 0;
    public $margeNet = 0;
    public $panierMoyenTtc = 0;
    public $panierMoyenNet = 0;
    public $margeNetAfterHoraire = 0;
    public $panierMoyenAfterHoraire = 0;

    public $commercial;
    public $debut;
    public $fin;

    protected $listeners = ['updateSelectCommercial', 'dateRange', 'resetCard'];


    public function mount(){
        if(Auth::user()->hasRole('commercial')) {
            $this->commercial = Auth::commercial();
        }else{
            $this->commercial = app(CommercialRepositoryContract::class)->newQuery()->first();
        }
    }

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

        if ($debut && $fin) {
            $this->debut = (new DateStringToCarbon())->handle($debut);
            $this->fin = (new DateStringToCarbon())->handle($fin);
        }
    }

    public function render(StatistiqueRepositoryContract $repStat, TimerRepositoryContract $repTimer)
    {
        if ($this->commercial) {
            $this->nombeHeureTravail = $repTimer->getTotalTimeByCommercialPeriode($this->commercial, $this->debut, $this->fin);
            $this->tauxHoraire = $repStat->getTauxHoraireByCommercial($this->commercial, $this->debut, $this->fin);
            $this->nombreLead = $repStat->getNombreLead($this->commercial, $this->debut, $this->fin);
            $this->nombreContrat = $repStat->getNombreContactByCommercial($this->commercial, $this->debut, $this->fin);
            $this->margeTtc = $repStat->getMargeTtcByCommercial($this->commercial, $this->debut, $this->fin);
            $this->margeNet = $repStat->getMargeNetByCommercial($this->commercial, $this->debut, $this->fin);
            $this->panierMoyenTtc = $repStat->getPanierMoyenTtcByCommercial($this->commercial, $this->debut, $this->fin);
            $this->panierMoyenNet = $repStat->getPanierMoyenNetByCommercial($this->commercial, $this->debut, $this->fin);
            $this->margeNetAfterHoraire = $repStat->getMargeNetAfterHoraireByCommercial($this->commercial, $this->debut, $this->fin);
            $this->tauxConversion = $repStat->getTauxConversionByCommercial($this->commercial, $this->debut, $this->fin);
            $this->panierMoyenAfterHoraire = $repStat->getPanierMoyenNetAfterHoraire($this->commercial,$this->debut, $this->fin);
        }

        return view('crmautocar::livewire.stats-admin-card');
    }
}
