<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\BaseCore\Contracts\Repositories\UserRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\ProformatsRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\StatistiqueReservationRepositoryContract;
use Modules\CrmAutoCar\Filters\ProformatFilterQuery;
use Modules\CrmAutoCar\Models\Proformat;
use Laravel\Octane\Facades\Octane;
use Modules\CrmAutoCar\Models\Traits\EnumStatusCancel;
use Modules\CrmAutoCar\Models\Traits\EnumStatusDemandeFournisseur;
use Modules\CrmAutoCar\Services\SortableComponent;

class ProformatsList extends Component
{
    use WithPagination;
    use SortableComponent;

    public $mois;
    public $commercialSelect;
    public $gestionnaire;
    public $commercial;

    public $paid;
    public $margeEnd;
    public $contact;
    public $infovoyage;
    public $margeEdited;
    public $ignoreoldcrm;
    public $statusFrs;
    public $canceled;

    public $dateStart;
    public $dateEnd;

    public $toinvoice;

    public $queryString = ['canceled', 'statusFrs', 'mois', 'gestionnaire','ignoreoldcrm', 'commercialSelect','toinvoice','order', 'direction', 'paid', 'margeEnd', 'contact', 'infovoyage', 'margeEdited', 'dateStart', 'dateEnd'];

    public $listeners = [
        'proformats.refresh' => '$refresh',
    ];

    public function mount(){
        $this->dateStart = now()->startOfMonth();
        $this->dateEnd = now()->endOfMonth();

        if(!$this->mois) {
            $this->mois = $this->dateStart->format('d/m/Y');
        }

        $this->order = 'created_at';
        $this->direction = 'desc';
    }

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
                           StatistiqueReservationRepositoryContract $repStats,
          UserRepositoryContract $userRep
    ): Factory|View|Application
    {

        $this->filtre();

        $commercials = $repcommercial->fetchAll();
        $gestionnaires = $userRep->newQuery()->whereHas('roles', function($query){
            $query->where('id', 7);
        })->get();
        //on prend le mois de la première facture et on va jusqu'au mois actuel avec l'année
        $firstDate = $proformatRep->newQuery()->orderBy('created_at', 'asc')->first()->created_at ?? now();
        $dateNow = now()->startOfDay()->startOfMonth();
        $byMois = [];
        for($date = $firstDate->clone()->startOfDay()->startOfMonth();$date->lessThanOrEqualTo($dateNow);$date->addMonth()){
            $byMois[] = $date->clone()->startOfMonth();
        }


        $filter = new ProformatFilterQuery();

//        $filter->byBureau(Auth::user());

        if (!Gate::allows('viewAny', Proformat::class)) {
            $filter->byCommercial(Auth::commercial());
        }else{
            $filter->byCommercial($this->commercial);
        }

        $filter->byGestionnaire($this->gestionnaire);
        if($this->paid === 'oui') $filter->paid();
        if($this->paid === 'non') $filter->notPaid();

        if($this->contact === 'oui') $filter->contactChauffeur();
        if($this->contact === 'non') $filter->notContactChauffeur();

        if($this->infovoyage === 'oui') $filter->infoVoyage();
        if($this->infovoyage === 'non') $filter->notInfoVoyage();

        if($this->toinvoice === 'oui') $filter->toInvoice();
        if($this->margeEnd === 'oui') $filter->margeDefinitve();

        if($this->ignoreoldcrm === 'oui') $filter->ignoreOldCrm();


        if($this->canceled !== 'oui'){
            $filter->ignoreAnnuler();
        }

        if($this->statusFrs) {
            $filter->withoutFrs($this->statusFrs);
        }

        if($this->margeEdited === 'oui') $filter->byMargeEdited($this->dateStart, $this->dateEnd);
        else{
            $filter->byCreatedAt($this->dateStart, $this->dateEnd);
        }

        $repStats->setQuery($filter->query());
        [$totalVente, $totalAchat, $totalMarge, $totalEncaissement,$salaireDiff, $isBalanced] = [
            $repStats->getTotalVente($this->dateStart, $this->dateEnd),
            $repStats->getTotalAchat($this->dateStart, $this->dateEnd),
            $repStats->getTotalMargeHT($this->dateStart, $this->dateEnd),
            $repStats->getTotalAEncaisser($this->dateStart, $this->dateEnd),
            $repStats->getSalaireDiff($this->dateStart, $this->dateEnd),
            $repStats->isBalanced(),
        ];


        $query = $filter->query();
        $this->querySort($query, [
            'created_at' => function($query, $direction){
                $query->orderBy('created_at', $direction);
            },
            'id' => function($query, $direction){
                $query->orderBy('id', $direction);
            },
            'client' => function($query, $direction){
                $query->orderBy(function($query){
                    $query
                        ->select(DB::raw('CONCAT(personnes.firstname,personnes.lastname) as format_name'))
                        ->from('clients')
                        ->leftJoin('personnes', 'personnes.id', '=', 'clients.personne_id')
                        ->leftJoin('devis', 'proformats.devis_id', '=', 'devis.id')
                        ->leftJoin('dossiers', 'dossiers.id', '=', 'devis.dossier_id')
                        ->whereColumn('clients.id','dossiers.clients_id')
                        ->limit(1);
                }, $direction);
            },
            'fournisseur' => function($query, $direction){
                $query->orderBy(function($query){
                    $query
                        ->selectRaw("json_unquote(json_extract(`users`.`data`, '$.company'))")
                        ->from('users')
                        ->leftJoin('devis', 'proformats.devis_id', '=', 'devis.id')
                        ->leftJoin('devi_fournisseurs', 'devi_fournisseurs.user_id', '=', 'users.id')
                        ->leftJoin('dossiers', 'dossiers.id', '=', 'devis.dossier_id')
                        ->whereColumn('devi_fournisseurs.devi_id','proformats.devis_id')
                        ->where('devi_fournisseurs.validate',true)
                        ->limit(1);
                }, $direction);
            },
            'date_depart' => function($query, $direction){
                $query->orderBy(function($query){
                    $query->from('devis')
                        ->selectRaw("json_unquote(json_extract(`data`, '$.trajets[0].aller_date_depart'))")
                        ->whereColumn(
                            'proformats.devis_id',
                            'devis.id'
                        )
                        ->limit(1);
                }, $direction);
            },
            'date_retour' => function($query, $direction){
                $query->orderBy(function($query){
                    $query->from('devis')
                        ->selectRaw("json_unquote(json_extract(`data`, '$.trajets[0].retour_date_depart'))")
                        ->whereColumn(
                            'proformats.devis_id',
                            'devis.id'
                        )
                        ->limit(1);
                }, $direction);
            },
            'encaisser' => function($query, $direction){
                $query->orderBy(function($query){
                    $query->from('proformats', 'pro')
                        ->selectRaw("(pro.total - IFNULL((SELECT COALESCE(SUM(total),0) FROM payments WHERE payments.proformat_id = pro.id GROUP BY payments.proformat_id),0)) as restant")
                        ->whereColumn(
                            'pro.id',
                            'proformats.id'
                        );

                }, $direction);
            },
        ]);

        $proformats = $query
            ->paginate(50);



        return view('crmautocar::livewire.proformats-list', [
            'proformats' => $proformats,
            'commercials' => $commercials,
            'gestionnaires' => $gestionnaires,
            'totalVente' => $totalVente,
            'totalAchat' => $totalAchat,
            'totalMarge' => $totalMarge,
            'totalEncaissement' => $totalEncaissement,
            'salaireDiff' => $salaireDiff,
            'byMois' => $byMois,
            'isBalanced' => $isBalanced,
            'statusForFrs' => [
                EnumStatusDemandeFournisseur::STATUS_VALIDATE => 'Valide',
                EnumStatusDemandeFournisseur::STATUS_BPA => 'Bpa',
                EnumStatusDemandeFournisseur::STATUS_REFUSED => 'Refuser',
                EnumStatusCancel::STATUS_CANCELED => 'Annuler',
            ]
        ]);
    }
}
