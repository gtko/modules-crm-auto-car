<?php


namespace Modules\CrmAutoCar\View\Components\Timeline;


use Illuminate\View\View;
use Modules\CoreCRM\View\Components\Timeline\TimelineComponent;

class ClientDossierDemandeFournisseurSend extends TimelineComponent
{

    function render(): View
    {
        return view('crmautocar::components.timeline.client.dossier.demande-fournisseur.send');
    }
}
