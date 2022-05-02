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
    public $nombeJourTravail = 0;
    public $tauxHoraire = 0;
    public $nombreLead = 0;
    public $nombreContrat = 0;
    public $tauxConversion = 0;
    public $marge = 0;
    public $margeNet = 0;
    public $panierMoyen = 0;
    public $panierMoyenNet = 0;
    public $margeNetAfterHoraire = 0;
    public $panierMoyenAfterHoraire = 0;

    public $commercial;
    public $debut;
    public $fin;
    public $bureau;

    public function mount($filtre){

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
    }


    public function render(StatistiqueRepositoryContract $repStat, TimerRepositoryContract $repTimer)
    {
        if ($this->commercial) {
            $this->nombeHeureTravail = $repTimer->getTotalTimeByCommercialPeriode($this->commercial, $this->debut, $this->fin);
            $this->nombeJourTravail = $repTimer->getTotalDaysPresentielByCommercialPeriode($this->commercial, $this->debut, $this->fin);
            $this->tauxHoraire = $repStat->getTauxHoraireByCommercial($this->commercial, $this->debut, $this->fin);
            $this->nombreLead = $repStat->getNombreLead($this->commercial, $this->debut, $this->fin);
            $this->nombreContrat = $repStat->getNombreContactByCommercial($this->commercial, $this->debut, $this->fin);
            $this->marge = $repStat->getMargeByCommercial($this->commercial, $this->debut, $this->fin);
            $this->margeNet = $repStat->getMargeNetByCommercial($this->commercial, $this->debut, $this->fin);
            $this->panierMoyen = $repStat->getPanierMoyenByCommercial($this->commercial, $this->debut, $this->fin);
            $this->panierMoyenNet = $repStat->getPanierMoyenNetByCommercial($this->commercial, $this->debut, $this->fin);
            $this->margeNetAfterHoraire = $repStat->getMargeNetAfterHoraireByCommercial($this->commercial, $this->debut, $this->fin);
            $this->tauxConversion = $repStat->getTauxConversionByCommercial($this->commercial, $this->debut, $this->fin);
            $this->panierMoyenAfterHoraire = $repStat->getPanierMoyenNetAfterHoraire($this->commercial,$this->debut, $this->fin);
        }

        return view('crmautocar::livewire.stats-admin-card');
    }
}
