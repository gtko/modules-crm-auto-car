<?php

namespace Modules\CrmAutoCar\Http\Livewire\Dossiers;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\StatusRepositoryContract;
use Modules\CoreCRM\Enum\StatusTypeEnum;
use Modules\CrmAutoCar\Contracts\Repositories\TagsRepositoryContract;
use Modules\CrmAutoCar\Filters\ClientFilterQuery;
use Modules\CrmAutoCar\Models\Dossier;

class ListClient extends Component
{

    public $nom_client = '';
    public $status;
    public $tag;
    public $commercial;
    public $departStart;
    public $departEnd;
    public $dateSignatrue;
    public $viewMyLead = false;

    public $resa = false;

    public $queryString = ['status'];

    protected $rules = [
        'nom_client' => '',
        'status' => '',
        'commercial' => '',
    ];

    public function mount($resa = false){
        $this->resa = $resa;
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
            $status = app(StatusRepositoryContract::class)->fetchById(5);
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
            $dossiers = $this->query()->orderBy('created_at', 'desc')->paginate(50);
        } else {

            $dossiers = $this->query()
                ->where('commercial_id', \Auth::user()->id)
                ->orWhereHas('followers', function($query){
                    $query->where('user_id', \Auth::user()->id);
                })
                ->orderBy('created_at', 'desc')
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
