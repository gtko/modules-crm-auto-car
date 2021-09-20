<?php

namespace Modules\CrmAutoCar\View\Components\DevisClient;

use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Illuminate\View\Component;

class Index extends Component
{
    /**
     * Get the views / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */


    public function index($devisId, DevisRepositoryContract $devisRep, $token)
    {

        $devis = $devisRep->fetchById($devisId);

        return view('crmautocar::components.devis-client.index', compact('devis'));
    }

    public function render()
    {
        return view('crmautocar::components.devis-client.index');
    }
}
