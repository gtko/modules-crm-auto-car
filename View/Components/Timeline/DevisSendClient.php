<?php

namespace Modules\CrmAutoCar\View\Components\Timeline;

use Illuminate\View\Component;
use Illuminate\View\View;
use Modules\CoreCRM\View\Components\Timeline\TimelineComponent;

class DevisSendClient extends TimelineComponent
{
    public function render(): View
    {
        return view('crmautocar::components.timeline.devis-send-client');
    }
}
