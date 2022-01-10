<?php

namespace Modules\CrmAutoCar\Http\Livewire\Dossiers;

use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\StatusRepositoryContract;

class ListClient extends Component
{

    public $nom_client = '';
    public $status;

    protected $rules = [
        'nom_client' => '',
        'status' => '',
    ];


    public function search()
    {
        $dossierRep = app(DossierRepositoryContract::class);
        if($this->status)
        {
            $dossierRep->setQuery($dossierRep->newQuery()->where('status_id', $this->status));
        }

        return $dossierRep->fetchSearch($this->nom_client ?? null);
    }

    public function render()
    {
        return view('crmautocar::livewire.dossiers.list-client',
            [
                'dossiers' => $this->search(),
                'statusList' => app(StatusRepositoryContract::class)->fetchAll(),
            ]);
    }
}
