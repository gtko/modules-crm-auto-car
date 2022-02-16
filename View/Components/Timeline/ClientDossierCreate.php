<?php

namespace Modules\CrmAutoCar\View\Components\Timeline;

use Illuminate\View\View;
use Modules\CoreCRM\View\Components\Timeline\TimelineComponent;


class ClientDossierCreate extends TimelineComponent
{
    /**
     * Get the views / contents that represent the component.
     *
     * @return \Illuminate\View\View
     */
    public function render(): View
    {

        return view('crmautocar::components.timeline.client.dossier.create');
    }
}
