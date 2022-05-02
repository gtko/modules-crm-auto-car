<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Illuminate\Support\Carbon;
use Livewire\Component;
use Modules\CrmAutoCar\Contracts\Repositories\ConfigsRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\ShekelRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\StatistiqueRepositoryContract;
use Modules\TimerCRM\Contracts\Repositories\TimerRepositoryContract;

class StatsAdminCardGlobal extends Component
{

    public $debut;
    public $bureau;
    public $fin;

    public $nombreLead = 0;
    public $nombreContact = 0;
    public $tauxConversion = 0;
    public $marge = 0;
    public $margeNet = 0;
    public $panierMoyen = 0;


    public $priceLead;
    public $leadPrice;
    public $editPriceLeadActive = false;
    public $shekel;

    protected $rules = [
        'priceLead' => 'required|numeric'
    ];

    public function mount($filtre){
        $this->debut = $filtre['debut'] ?? null;
        $this->fin = $filtre['fin'] ?? null;
        $this->bureau = $filtre['bureau'] ?? null;


        if($this->debut){
            $this->debut = Carbon::parse($this->debut);
        }

        if($this->fin){
            $this->fin = Carbon::parse($this->fin);
        }
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

    public function render(StatistiqueRepositoryContract $repStat, TimerRepositoryContract $repTimer, ConfigsRepositoryContract $repConfig)
    {
        $this->leadPrice = $repConfig->getByName('price_lead')->data['price_lead'] ?? 0;
        $this->shekel = app(ShekelRepositoryContract::class)->getPrice();

        $repStat->filterByBureau($this->bureau);

        $this->nombreLeads = $repStat->getNombreLeadTotal($this->debut, $this->fin);
        $this->nombreContact = $repStat->getNombreContactWinTotal($this->debut, $this->fin);
        $this->tauxConversion = $repStat->getTauxConversionTotal($this->debut, $this->fin);
        $this->marge = $repStat->getMargeTotal($this->debut, $this->fin);
        $this->margeNet = $repStat->getMargeNetTotal($this->debut, $this->fin);
        $this->panierMoyen = $repStat->getPannierMoyenTotal($this->debut, $this->fin);
        $this->panierNet = $repStat->getPannierNetTotal($this->debut, $this->fin);


        return view('crmautocar::livewire.stats-admin-card-global');
    }
}
