<?php

namespace Modules\CrmAutoCar\Http\Livewire\Dossiers;

use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\StatusRepositoryContract;
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
    public $viewMyLead = false;

    public $queryString = ['status'];

    protected $rules = [
        'nom_client' => '',
        'status' => '',
        'commercial' => '',
    ];

    public function query()
    {
        $filter = (new ClientFilterQuery());
        $filter->byStatus($this->status);
        $filter->byCommercial($this->commercial);
        $filter->byTag($this->tag);
        $filter->search($this->nom_client);

        $filter->byDepart($this->departStart);
        $filter->byArrive($this->departEnd);

        return $filter->query();
    }

    public function clearFiltre()
    {
        $this->nom_client = '';
        $this->status = '';
        $this->tag = '';
        $this->commercial = '';
        $this->departStart = '';
        $this->departEnd = '';
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
                'commercialList' => app(CommercialRepositoryContract::class)->fetchAll(),
                'tagList' => app(TagsRepositoryContract::class)->fetchAll()
            ]);
    }
}
