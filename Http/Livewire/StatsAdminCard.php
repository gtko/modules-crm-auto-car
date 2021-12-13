<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\BaseCore\Actions\Dates\DateStringToCarbon;
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
            $this->tauxHoraire = $repStat->getTauxHoraireByCommercial();
            $this->nombreLead = $repStat->getNombreLead($this->commercial, $this->debut, $this->fin);;
            $this->nombreContrat = $repStat->getNombreContactByCommercial();
            $this->margeTtc = $repStat->getMargeTtcByCommercial();
            $this->margeNet = $repStat->getMargeNetAfterHoraireByCommercial();
            $this->panierMoyenTtc = $repStat->getPanierMoyenTtcByCommercial();
            $this->panierMoyenNet = $repStat->getPanierMoyenNetByCommercial();
            $this->margeNetAfterHoraire = $repStat->getMargeNetAfterHoraireByCommercial();
            $this->panierMoyenAfterHoraire = $repStat->getPanierMoyenNetAfterHoraire();
        }

        return view('crmautocar::livewire.stats-admin-card');
    }
}
