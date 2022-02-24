<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\ProformatsRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\StatistiqueReservationRepositoryContract;
use Modules\CrmAutoCar\Filters\ProformatFilterQuery;
use Modules\CrmAutoCar\Models\Proformat;
use Laravel\Octane\Facades\Octane;

class ProformatsList extends Component
{


    public $mois;
    public $commercialSelect;
    public $commercial;

    public $paid;
    public $contact;
    public $infovoyage;
    public $margeEdited;

    public $dateStart;
    public $dateEnd;

    public $listeners = [
        'proformats.refresh' => '$refresh',
    ];


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

        if (!Gate::allows('viewAny', Proformat::class)) {
            $filter->byCommercial(Auth::commercial());
        }else{
            $filter->byCommercial($this->commercial);
        }

        if($this->paid === 'oui') $filter->paid();
        if($this->paid === 'non') $filter->notPaid();

        if($this->contact === 'oui') $filter->contactChauffeur();
        if($this->contact === 'non') $filter->notContactChauffeur();

        if($this->infovoyage === 'oui') $filter->infoVoyage();
        if($this->infovoyage === 'non') $filter->notInfoVoyage();

        if($this->margeEdited === 'oui') $filter->byMargeEdited($this->dateStart, $this->dateEnd);
        else{
            $filter->byCreatedAt($this->dateStart, $this->dateEnd);
        }

        $proformats = $filter->query()->has('devis')->orderBy('created_at', 'DESC')->paginate(50);

        //on prend le mois de la première facture et on va jusqu'au mois actuel avec l'année
        $firstDate = $proformatRep->newQuery()->first()->created_at ?? now();
        $dateNow = now()->startOfDay()->startOfMonth();
        $byMois = [];
        for($date = $firstDate->clone()->startOfDay()->startOfMonth();$date->lessThanOrEqualTo($dateNow);$date->addMonth()){
            $byMois[] = $date->clone()->startOfMonth();
        }



        [$totalVente, $totalAchat, $totalMarge, $totalEncaissement,$salaireDiff] = [
            $repStats->getTotalVente($this->dateStart, $this->dateEnd),
            $repStats->getTotalAchat($this->dateStart, $this->dateEnd),
            $repStats->getTotalMargeHT($this->dateStart, $this->dateEnd),
            $repStats->getTotalAEncaisser($this->dateStart, $this->dateEnd),
            $repStats->getSalaireDiff($this->dateStart, $this->dateEnd),
        ];

        return view('crmautocar::livewire.proformats-list', [
            'proformats' => $proformats,
            'commercials' => $commercials,
            'totalVente' => $totalVente,
            'totalAchat' => $totalAchat,
            'totalMarge' => $totalMarge,
            'totalEncaissement' => $totalEncaissement,
            'salaireDiff' => $salaireDiff,
            'byMois' => $byMois
        ]);
    }
}
