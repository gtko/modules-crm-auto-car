<?php


namespace Modules\CrmAutoCar\View\Components\Timeline;


use Illuminate\View\View;
use Modules\CoreCRM\View\Components\Timeline\TimelineComponent;

class SendInformationVoyageMailFournisseur extends TimelineComponent
{

    function render(): View
    {
        return view('crmautocar::components.timeline.client.dossier.devis.send-information-voyage');
    }
}
