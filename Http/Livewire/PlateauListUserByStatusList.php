<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\StatusRepositoryContract;

class PlateauListUserByStatusList extends Component
{
    public $dossiers;

    public function mount(DossierRepositoryContract $repDossier, CommercialRepositoryContract $repCommercial, StatusRepositoryContract $repStatus, $commercialId, $statusId)
    {
        $modelStatus = $repStatus->fetchById($statusId);
        $modelCommercial = $repCommercial->fetchById($commercialId);
        $this->dossiers = $repDossier->getDossiersByCommercialAndStatus($modelCommercial, $modelStatus);
    }

    public function render()
    {
        return view('crmautocar::livewire.plateau-list-user-by-status-list');
    }
}
