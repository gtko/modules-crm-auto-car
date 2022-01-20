<?php

namespace Modules\CrmAutoCar\Http\Livewire\Dossiers;

use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\StatusRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\TagsRepositoryContract;
use Modules\CrmAutoCar\Filters\ClientFilterQuery;

class ListClient extends Component
{

    public $nom_client = '';
    public $status;
    public $tag;
    public $commercial;
    public $departStart;
    public $departEnd;

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

        $filter->byDateDepart($this->departStart, $this->departEnd);

        return $filter->query();
    }

    public function clearFiltre()
    {
        $this->nom_client = '';
        $this->status = '';
        $this->tag = '';
        $this->commercial = '';
        $this->departEnd = '';
        $this->departStart = '';
    }

    public function render()
    {
        return view('crmautocar::livewire.dossiers.list-client',
            [
                'dossiers' => $this->query()->orderBy('created_at', 'desc')->paginate(50),
                'statusList' => app(StatusRepositoryContract::class)->fetchAll(),
                'commercialList' => app(CommercialRepositoryContract::class)->fetchAll(),
                'tagList' => app(TagsRepositoryContract::class)->fetchAll()
            ]);
    }
}
