<?php

namespace Modules\CrmAutoCar\Http\Livewire\Dossiers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\StatusRepositoryContract;
use Modules\CoreCRM\Enum\StatusTypeEnum;
use Modules\CrmAutoCar\Contracts\Repositories\TagsRepositoryContract;
use Modules\CrmAutoCar\Filters\ClientFilterQuery;
use Modules\CrmAutoCar\Models\Dossier;
use Modules\CrmAutoCar\Services\SortableComponent;

class ListClient extends Component
{

    use SortableComponent;

    public $nom_client = '';
    public $status;
    public $tag;
    public $commercial;
    public $departStart;
    public $departEnd;
    public $dateSignatrue;
    public $viewMyLead = false;

    public $resa = false;

    public $queryString = ['status','order', 'direction'];

    protected $rules = [
        'nom_client' => '',
        'status' => '',
        'commercial' => '',
    ];

    public function mount($resa = false){
        $this->resa = $resa;

        $this->order = 'updated_at';
    }

    public function query()
    {
        $filter = (new ClientFilterQuery());

        $filter->byStatus($this->status);
        $filter->byCommercial($this->commercial);
        $filter->byTag($this->tag);
        $filter->search($this->nom_client);

        $filter->byDateSignature($this->dateSignatrue);
        $filter->byDepart($this->departStart);
        $filter->byArrive($this->departEnd);

        $query = $filter->query();

        if($this->resa){
            $status = app(StatusRepositoryContract::class)->fetchById(8);
            $query->whereHas('status', function($query) use ($status){
                $query->where('order', '>=', $status->order);
            });
            if(!$this->status){
                $status = app(StatusRepositoryContract::class)->newQuery()
                    ->where("type", StatusTypeEnum::TYPE_WIN)
                    ->orWhere("type", StatusTypeEnum::TYPE_LOST)
                    ->pluck('id')->toArray();
                $query->whereHas('status', function($query) use ($status){
                    $query->whereNotIn('id', $status);
                });
            }
        }


        $this->querySort($query, [
            'created_at' => function($query, $direction){
                $query->orderBy('created_at', $direction);
            },
            'updated_at' => function($query, $direction){
                $query->orderBy(function($query){
                    $query->from('devis')
                        ->select('updated_at')
                        ->whereColumn(
                            'devis.dossier_id',
                            'dossiers.id'
                        )
                        ->limit(1);
                }, $direction);
            },
            'id' => function($query, $direction){
                $query->orderBy('id', $direction);
            },
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
            'company' => function($query, $direction) {
                $query->orderBy(function($query){
                    $query
                        ->select('company')
                        ->from('clients')
                        ->whereColumn('clients.id','dossiers.clients_id')
                        ->limit(1);
                }, $direction);
            },
            'statut' => function($query, $direction) {
                $query->orderBy(function($query){
                    $query
                        ->select('statuses.order')
                        ->from('statuses')
                        ->whereColumn('statuses.id','dossiers.status_id');
                }, $direction);
            },
            'date_voyage' => function($query, $direction) {
                $query->orderBy(function($query){
                    $query->from('devis')
                        ->select('data->trajets->0->aller_date_depart')
                        ->whereColumn(
                            'devis.dossier_id',
                            'dossiers.id'
                        )
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
            'gestionnaire' => function($query, $direction) {
                $query->orderBy(function($query){
                    $query
                        ->select(DB::raw('CONCAT(personnes.firstname,personnes.lastname) as format_name'))
                        ->from('users')
                        ->leftJoin('personnes', 'personnes.id', '=', 'users.personne_id')
                        ->leftJoin('dossier_user', 'dossier_user.user_id', '=', 'users.id')
                        ->whereColumn('dossier_user.dossier_id','dossiers.id')
                        ->limit(1);
                }, $direction);
            },
        ]);



        return $query;
    }

    public function clearFiltre()
    {
        $this->nom_client = '';
        $this->status = '';
        $this->tag = '';
        $this->commercial = '';
        $this->departStart = '';
        $this->departEnd = '';
        $this->dateSignatrue = '';
    }

    public function render()
    {
        if (!$this->viewMyLead && Auth::user()->can('viewAll', \Modules\CoreCRM\Models\Dossier::class)) {
            $dossiers = $this->query()->paginate(50);
        } else {

            $dossiers = $this->query()
                ->where('commercial_id', \Auth::user()->id)
                ->orWhereHas('followers', function($query){
                    $query->where('user_id', \Auth::user()->id);
                })
                ->paginate(50);
        }

        $pipelineList = app(StatusRepositoryContract::class)->fetchAll();
        $pipelineList = $pipelineList->groupBy('pipeline_id');


        return view('crmautocar::livewire.dossiers.list-client',
            [
                'dossiers' => $dossiers,
                'pipelineList' => $pipelineList,
                'commercialList' => app(CommercialRepositoryContract::class)->newquery()->role('commercial')->get(),
                'tagList' => app(TagsRepositoryContract::class)->fetchAll()
            ]);
    }
}
