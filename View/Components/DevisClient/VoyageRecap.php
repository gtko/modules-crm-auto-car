<?php

namespace Modules\CrmAutoCar\View\Components\DevisClient;

use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Illuminate\View\Component;
use Modules\CrmAutoCar\Models\Brand;

class VoyageRecap extends Component
{
    /**
     * Get the views / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */

    public DevisEntities $devis;
    public Brand $brand;

    public function __construct($devis, $brand) {
        $this->devis = $devis;
        $this->brand = $brand;
    }

    public function render()
    {

        return view('crmautocar::components.devis-client.voyage-recap');
    }
}
