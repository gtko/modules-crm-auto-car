<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\ProformatsRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\StatistiqueReservationRepositoryContract;
use Modules\CrmAutoCar\Filters\ProformatFilterQuery;

class ProformatsList extends Component
{


    public $mois;
    public $commercialSelect;
    public $commercial;

    public $paid;

    public $dateStart;
    public $dateEnd;


    public function updatedMois()
    {
        $this->filtre();
    }

    public function updatedCommercialSelect()
    {

        $this->filtre();

    }

    public function filtre()
    {
        $repCommercial = app(CommercialRepositoryContract::class);

        if($this->commercialSelect) {
            $this->commercial = $repCommercial->fetchById($this->commercialSelect);
        }else{
            $this->commercial = null;
        }

        if($this->mois){
            $date = Carbon::createFromFormat('d/m/Y', $this->mois);
            $this->dateStart = $date->clone()->startOfDay()->startOfMonth();
            $this->dateEnd = $date->clone()->endOfDay()->endOfMonth();
        }else{
            $this->dateStart = null;
            $this->dateEnd = null;
        }

    }

    public function render(ProformatsRepositoryContract $proformatRep,
                           CommercialRepositoryContract $repcommercial,
                           StatistiqueReservationRepositoryContract $repStats
    ): Factory|View|Application
    {
        $commercials = $repcommercial->fetchAll();

        $filter = new ProformatFilterQuery();
        $filter->byCommercial($this->commercial);
        $filter->byCreatedAt($this->dateStart, $this->dateEnd);

        if($this->paid === 'oui') $filter->paid();
        if($this->paid === 'non') $filter->notPaid();

        $proformats = $filter->query()->paginate(50);



        //on prend le mois de la première facture et on va jusqu'au mois actuel avec l'année
        $firstDate = $proformatRep->newQuery()->first()->created_at ?? now();
        $dateNow = now()->startOfDay()->startOfMonth();
        $byMois = [];
        for($date = $firstDate->clone()->startOfDay()->startOfMonth();$date->lessThanOrEqualTo($dateNow);$date->addMonth()){
            $byMois[] = $date->clone()->startOfMonth();
        }

        return view('crmautocar::livewire.proformats-list', [
            'proformats' => $proformats,
            'commercials' => $commercials,
            'totalVente' => $repStats->getTotalVente($this->dateStart, $this->dateEnd),
            'totalAchat' => $repStats->getTotalAchat($this->dateStart, $this->dateEnd),
            'totalMarge' => $repStats->getTotalMargeHT($this->dateStart, $this->dateEnd),
            'totalEncaissement' => $repStats->getTotalAEncaisser($this->dateStart, $this->dateEnd),
            'byMois' => $byMois
        ]);
    }
}
