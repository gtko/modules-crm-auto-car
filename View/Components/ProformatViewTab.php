<?php

namespace Modules\CrmAutoCar\View\Components;

use Illuminate\View\Component;

class ProformatViewTab extends Component
{
    public function __construct(Public $client, public $dossier){}


    public function render()
    {
        return view('crmautocar::components.proformat-view-tab');
    }
}
