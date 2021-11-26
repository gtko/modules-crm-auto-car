<?php

namespace Modules\CrmAutoCar\View\Components;

use Illuminate\View\Component;
use Modules\CoreCRM\Models\Workflow;

class WorkflowActif extends Component
{

    public function __construct(public Workflow $workflow){}

    public function render()
    {
        return view('crmautocar::components.workflow-actif');
    }
}
