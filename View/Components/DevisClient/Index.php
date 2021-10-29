<?php

namespace Modules\CrmAutoCar\View\Components\DevisClient;


use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Illuminate\View\Component;
use Modules\CoreCRM\Services\FlowCRM;
use Modules\CrmAutoCar\Flow\Attributes\ClientDevisExterneConsultation;
use Request;

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


        (new FlowCRM())->add($devis->dossier , new ClientDevisExterneConsultation($devis, Request::ip()));


        return view('crmautocar::components.devis-client.index', compact('devis'));

    }

    public function render()
    {
        return view('crmautocar::components.devis-client.index');
    }
}
