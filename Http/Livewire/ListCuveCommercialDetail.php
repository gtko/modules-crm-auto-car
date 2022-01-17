<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\CoreCRM\Models\Commercial;

class ListCuveCommercialDetail extends Component
{
    public $countDossierByDay;
    public $countDossierByMounth;
    public $commercial;

    public function mount(Commercial $commercial)
    {
        $this->commercial = $commercial;
    }

    public function render()
    {
        $commercialRepo = app(CommercialRepositoryContract::class);

        $this->countDossierByDay = $commercialRepo->countClientByDays($this->commercial);
        $this->countDossierByMounth = $commercialRepo->countClientByMounth($this->commercial);

        return view('crmautocar::livewire.list-cuve-commercial-detail');
    }
}
