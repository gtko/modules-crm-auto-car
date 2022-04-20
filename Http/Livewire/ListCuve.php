<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\PipelineRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\SourceRepositoryContract;
use Modules\CoreCRM\Models\Commercial;

class ListCuve extends Component
{

    public $selection;
    public $commercial;
    public $filtre = 'attente';
    public $order = 'created_at';
    public $direction = 'DESC';
    public $all;

    public $queryString = ['filtre', 'order', 'direction'];

    protected $listeners = [
        'dossierSelected',
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

        $query->orderBy($this->order, $this->direction);

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
