<?php

namespace Modules\CrmAutoCar\Http\Livewire;

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
        $commercials = app(CommercialRepositoryContract::class)->fetchAll();
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

        if(empty($dossiers))
        {
            $total = $dossiers->total();
            $next = $dossiers->nextPageUrl();
            $prev = $dossiers->previousPageUrl();
        } else {
            $total = '';
            $next = '';
            $prev = '';
        }

        return view('crmautocar::livewire.list-cuve', compact(['dossiers', 'total', 'next', 'prev', 'commercials', 'pipelines']));
    }
}
