<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\CoreCRM\Models\Commercial;

class StatAdminClientList extends Component
{

    public $dossiers;
    public $commercial;

    protected $listeners = ['updateSelectCommercial'];

    public function updateSelectCommercial(Commercial $commercial)
    {
        $this->commercial = $commercial;

    }

    public function render(CommercialRepositoryContract $repCommercial,)
    {
        if ($this->commercial) {
            $this->dossiers = $repCommercial->getClients($this->commercial);
        }

        return view('crmautocar::livewire.stat-admin-client-list');
    }
}
