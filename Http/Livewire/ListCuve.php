<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\PipelineRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\SourceRepositoryContract;
use Modules\CoreCRM\Models\Commercial;
use Modules\CrmAutoCar\Services\SortableComponent;

class ListCuve extends Component
{

    use SortableComponent;

    public $selection = [];
    public $commercial;


    public $filtre = 'attente';

    public $paginate = 10;
    public $all;

    public $queryString = ['filtre', 'order', 'direction'];

    protected $listeners = [
        'dossierSelected',
        "dossierUnselected",
        'refresh' => '$refresh',
    ];

    protected $rules = [
        'commercial' => 'required'
    ];

    public function updatedAll()
    {
        $this->emit('allSelect' , $this->all);
    }

    public function changeFiltre($value)
    {
        $this->filtre = $value;
    }

    public function dossierSelected($value)
    {

        $this->selection[] = $value;

    }

    public function dossierUnselected($value){
        $this->selection = collect($this->selection)
            ->filter(function ($item) use ($value) {
                return $item['id'] !== $value['id'];
            })
            ->toArray();
    }


    public function attribuer()
    {
        $this->validate();
        $this->emit('listcuve:attribuer', $this->commercial);
        $this->emit('cuveRefresh');
        $this->commercial = '';

    }

    public function render()
    {
        $dossierRep = app(DossierRepositoryContract::class);
        $commercials = app(CommercialRepositoryContract::class)
            ->newQuery()
            ->where('enabled', true)
            ->role('commercial')
            ->get();
        $pipelines = app(PipelineRepositoryContract::class)->fetchall();


        $query = $dossierRep->newQuery()
            ->with(['client.personne.emails', 'commercial.personne', 'source']);

        $this->querySort($query, [
            'created_at' => fn($query, $direction) => $query->orderBy('created_at', $direction),
            'format_name' => function($query, $direction) {
                $query->orderBy(function($query){
                     $query
                         ->select(DB::raw('CONCAT(personnes.firstname,personnes.lastname) as format_name'))
                         ->from('clients')
                         ->leftJoin('personnes', 'personnes.id', '=', 'clients.personne_id')
                         ->whereColumn('clients.id','dossiers.clients_id')
                         ->limit(1);
                 }, $direction);
            },
            'status' => function($query, $direction) {
                $query->orderBy('status_id', $direction);
            },
            'email' => function($query, $direction) {
                $query->orderBy(function($query){
                    $query->select('emails.email')
                        ->from('clients')
                        ->join('personnes', 'personnes.id', '=', 'clients.personne_id')
                        ->join('email_personne', 'email_personne.personne_id', '=', 'personnes.id')
                        ->join('emails', 'email_personne.email_id', '=', 'emails.id')
                        ->whereColumn('clients.id','dossiers.clients_id')
                        ->limit(1);
                }, $direction);
            },
            'phone' => function($query, $direction) {
                $query->orderBy(function($query){
                    $query->select('phones.phone')
                        ->from('clients')
                        ->join('personnes', 'personnes.id', '=', 'clients.personne_id')
                        ->join('personne_phone', 'personne_phone.personne_id', '=', 'personnes.id')
                        ->join('phones', 'personne_phone.phone_id', '=', 'phones.id')
                        ->whereColumn('clients.id','dossiers.clients_id')
                        ->limit(1);
                }, $direction);
            },
            'commercial' => function($query, $direction) {
                $query->orderBy(function($query){
                    $query
                        ->select(DB::raw('CONCAT(personnes.firstname,personnes.lastname) as format_name'))
                        ->from('users')
                        ->leftJoin('personnes', 'personnes.id', '=', 'users.personne_id')
                        ->whereColumn('users.id','dossiers.commercial_id')
                        ->limit(1);
                }, $direction);
            },
            'date_reception' => function($query, $direction) {
                $query->orderBy('created_at', $direction);
            },
            'date_depart' => function($query, $direction) {
                $query->orderBy('data->date_depart', $direction);
            },
            'lieu_depart' => function($query, $direction) {
                $query->orderBy('data->lieu_depart', $direction);
            },
            'date_arrivee' => function($query, $direction) {
                $query->orderBy('data->date_arrivee', $direction);
            },
            'lieu_arrivee' => function($query, $direction) {
                $query->orderBy('data->lieu_arrivee', $direction);
            },
        ]);

//        dd($query->toSql());

        $dossierRep->setQuery($query);

        if ($this->filtre == "corbeille")
        {
            $dossiers = $dossierRep->getQueryDossierTrashed()->paginate(50);
        }
        elseif ($this->filtre == "distribuer")
        {
            $dossiers = $dossierRep->getQueryDossierAttribute()->paginate(50);
        }
        else{
            $dossiers = $dossierRep->getQueryDossierNotAttribute()->paginate(50);
        }

        return view('crmautocar::livewire.list-cuve', compact(['dossiers', 'commercials', 'pipelines']));
    }
}
