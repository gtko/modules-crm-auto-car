<?php

namespace Modules\CrmAutoCar\View\Components;

use Illuminate\View\Component;

class ProformatLabelTab extends Component
{

    public function __construct(Public $client, public $dossier){}

    public function render()
    {
        return view('crmautocar::components.proformat-label-tab');
    }
}
