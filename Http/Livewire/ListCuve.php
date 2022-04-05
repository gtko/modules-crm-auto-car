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
    public $all;

    public $queryString = ['filtre'];

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

        $dossierRep->setQuery($dossierRep->newQuery()->with(['client.personne.emails', 'client.personne.address.country', 'commercial.personne', 'source'])
            ->orderByDesc('created_at'));

        if ($this->filtre == "attente")
        {
            $dossiers = $dossierRep->getDossierNotAttribute();
        }
        elseif ($this->filtre == "distribuer")
        {
            $dossiers = $dossierRep->getDossierAttribute();
        }
        elseif ($this->filtre == 'corbeille') {

            $dossiers = $dossierRep->getDossierTrashed();
        }

        if($dossiers)
        {
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $perPage = 5000;
            $currentItems = $dossiers->slice($perPage * ($currentPage - 1), $perPage);
            $dossiers = (new LengthAwarePaginator($currentItems, count($dossiers), $perPage, $currentPage));
        }

        return view('crmautocar::livewire.list-cuve', compact(['dossiers', 'commercials', 'pipelines']));
    }
}
