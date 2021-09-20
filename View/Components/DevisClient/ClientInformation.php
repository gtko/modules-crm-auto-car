<?php

namespace Modules\CrmAutoCar\View\Components\DevisClient;

use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Illuminate\View\Component;

class ClientInformation extends Component
{
    /**
     * Get the views / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */

    public DevisEntities $devis;

    public function __construct($devis) {
        $this->devis = $devis;
    }

    public function render()
    {
        return view('crmautocar::components.devis-client.client-information');
    }
}
