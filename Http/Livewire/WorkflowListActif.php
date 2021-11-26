<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\WorkflowRepositoryContract;
use Modules\CoreCRM\Models\Workflow;

class WorkflowListActif extends Component
{

    public $workflow;

    public function mount(Workflow $workflow){
        $this->workflow = $workflow;
    }

    public function toggle(){
        $workflowRep = app(WorkflowRepositoryContract::class);
        if($this->workflow->active){
            $workflowRep->desactivate($this->workflow);
        }else {
            $workflowRep->activate($this->workflow);
        }
    }

    public function render()
    {
        return view('crmautocar::livewire.workflow-list-actif');
    }
}
