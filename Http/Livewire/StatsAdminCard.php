<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\BaseCore\Actions\Dates\DateStringToCarbon;
use Modules\CoreCRM\Models\Commercial;
use Modules\CrmAutoCar\Contracts\Repositories\StatistiqueRepositoryContract;

class StatsAdminCard extends Component
{

    protected $listeners = ['updateSelectCommercial', 'dateRange'];

    public $nombreLeads = 0;
    public $tauxConversion = 0;
    public $margeMoyenne = 0;
    public $chiffreAffaireMoyenClient = 0;
    public $nombreFormulaire = 0;
    public $totalTemps = 0;

    public $commercial;
    public $debut;
    public $fin;

    public function updateSelectCommercial(Commercial $commercial)
    {
        $this->commercial = $commercial;
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

    public function render(StatistiqueRepositoryContract $repStat)
    {
        if ($this->commercial) {
            $this->nombreLeads = $repStat->getNombreLead($this->commercial, $this->debut, $this->fin);
            $this->tauxConversion = $repStat->getTauxConversion();
            $this->margeMoyenne = $repStat->getMargeMoyenne();
            $this->chiffreAffaireMoyenClient = $repStat->getChiffreAffaireMoyenByClient();
        }

        return view('crmautocar::livewire.stats-admin-card');
    }
}
