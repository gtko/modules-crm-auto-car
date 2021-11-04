<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\SourceRepositoryContract;
use Modules\CoreCRM\Models\Commercial;

class ListCuve extends Component
{

    public $selection;
    public $commercial;
    public $filtre = 'attente';

    protected $listeners = [
        'dossierSelected',
    ];

    protected $rules = [
        'commercial' => 'required'
    ];


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
        $sourceRep = app(SourceRepositoryContract::class);
        $commercials = app(CommercialRepositoryContract::class)->fetchAll();

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

        $sources = $sourceRep->fetchAll();

        return view('crmautocar::livewire.list-cuve', compact(['dossiers', 'total', 'next', 'prev', 'sources', 'commercials']));
    }
}
