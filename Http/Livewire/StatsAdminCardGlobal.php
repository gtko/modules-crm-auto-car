<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\BaseCore\Actions\Dates\DateStringToCarbon;
use Modules\CoreCRM\Models\Commercial;
use Modules\CrmAutoCar\Contracts\Repositories\ConfigsRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\StatistiqueRepositoryContract;
use Modules\TimerCRM\Contracts\Repositories\TimerRepositoryContract;

class StatsAdminCardGlobal extends Component
{
    public $nombreLeads = 0;
    public $tauxConversion = 0;
    public $margeMoyenne = 0;
    public $chiffreAffaireMoyenClient = 0;
    public $nombreFormulaire = 0;
    public $totalTemps = '0';

    public $debut;
    public $fin;
    public $priceLead;
    public $leadPrice;
    public $editPriceLeadActive = false;

    protected $listeners = ['dateRangeGlobal', 'resetCardGlobal'];

    protected $rules = [
        'priceLead' => 'required|numeric'
    ];


    public function resetCardGlobal($debut, $fin)
    {
        $this->debut = $debut;
        $this->fin = $fin;
    }

    public function editPriceLead()
    {
        $this->editPriceLeadActive = true;
        $this->priceLead = $this->leadPrice;
    }

    public function changePriceLead()
    {
        $repConfig = app(ConfigsRepositoryContract::class);
        $modelConfig = $repConfig->getByName('price_lead');

        $this->validate();

        $data = [
            'price_lead' => $this->priceLead
        ];

        if ($modelConfig) {
            $repConfig->update($modelConfig, $data);
        } else {
            $repConfig->create('price_lead', $data);
        }
        $this->editPriceLeadActive = false;

    }

    public
    function dateRangeGlobal($debut, $fin)
    {
        if ($debut && $fin) {
            $this->debut = (new DateStringToCarbon())->handle($debut);
            $this->fin = (new DateStringToCarbon())->handle($fin);
        }
    }

    public
    function render(StatistiqueRepositoryContract $repStat, TimerRepositoryContract $repTimer, ConfigsRepositoryContract $repConfig)
    {
        $this->leadPrice = $repConfig->getByName('price_lead')->data['price_lead'];

        $this->nombreLeads = $repStat->getNombreLeadTotal($this->debut, $this->fin);
        $this->tauxConversion = $repStat->getTauxConversionTotal();
        $this->margeMoyenne = $repStat->getMargeMoyenneTotal();
        $this->chiffreAffaireMoyenClient = $repStat->getChiffreAffaireMoyenByClientTotal();


        return view('crmautocar::livewire.stats-admin-card-global');
    }
}
