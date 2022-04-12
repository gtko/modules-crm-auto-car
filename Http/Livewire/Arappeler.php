<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\CallCRM\Http\Livewire\Appel;
use Modules\CoreCRM\Contracts\Services\FlowContract;
use Modules\CoreCRM\Services\FlowCRM;
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierRappeler;
use Modules\TaskCalendarCRM\Contracts\Repositories\TaskRepositoryContract;
use Modules\TaskCalendarCRM\Flow\Attributes\AddTaskCreate;

class Arappeler extends Component
{

    public $dossier;

    public function mount($client, $dossier){
        $this->dossier = $dossier;
    }

    public function rappeler(){

        $task = app(TaskRepositoryContract::class)
            ->createTask(Auth::user(),
                Carbon::now()->addHours(24),
                'Rappel',
                'Rappeler le client '.$this->dossier->client->format_name,
                route('dossiers.show', [$this->dossier->client, $this->dossier]),
                0,
                "#7413cf",
                $this->dossier,
                ['type' => 'appel']);

        app(FlowContract::class)->add($this->dossier, new AddTaskCreate($task));
        app(FlowContract::class)
            ->add($this->dossier, new ClientDossierRappeler($this->dossier, $this->dossier->commercial, Auth::user()));

        return redirect()->route('dossiers.show', [$this->dossier->client, $this->dossier]);
    }

    public function render()
    {
        return view('crmautocar::livewire.arappeler');
    }
}
