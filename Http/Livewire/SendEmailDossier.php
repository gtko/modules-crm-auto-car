<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\CoreCRM\Flow\Works\Actions\ActionsSendNotification;
use Modules\CoreCRM\Flow\Works\WorkflowKernel;
use Modules\CoreCRM\Mail\WorkFlowStandardMail;
use Modules\CrmAutoCar\Contracts\Repositories\TemplatesRepositoryContract;
use Modules\CrmAutoCar\Flow\Works\Events\EventClientDossierRappeler;

class SendEmailDossier extends Component
{

    use WithFileUploads;

    public $dossier;
    public $client;

    public $preview = false;

    public $variableData = [];

    public $email = [
        'subject' => '',
        'sender' => '',
        'body' => '',
        'template' => '',
        'model' => '',
        'cc' => '',
        'cci' => '',
        'attachments' => [],
        ''
    ];

    public $rules = [
        'email.subject' => 'required',
        'email.sender' => 'required',
        'email.body' => 'required',
        'email.template' => 'required',
        'email.cc' => 'required',
        'email.cci' => '',
        'email.attachments' => '',
    ];

    public function mount($dossier, $client){
        $this->dossier = $dossier;
        $this->client = $client;
    }

    public function updatedEmailModel($field, $value){
        $template = app(TemplatesRepositoryContract::class)->fetchById($this->email['model']);
        $this->email['body'] = $template->content;
    }

    public function preview(){
        $this->preview = true;
    }

    public function editer(){
        $this->preview = false;
    }

    public function getEmailPreviewProperty(){



        $maillable = new WorkFlowStandardMail(
            $this->email['subject'],
            $this->email['cci'] ?? '',
            $this->email['body'],
            [],
            'default'
        );

        return $maillable->render();
    }

    public function send(){

    }

    public function render()
    {
        $templates = app(TemplatesRepositoryContract::class)->all();


        $workflowEvent = new EventClientDossierRappeler();
        if(empty($this->variableData)) {
            $this->variableData = [];
            foreach ($workflowEvent->variables() as $variable) {
                foreach ($variable->labels() as $label => $description) {
                    $this->variableData[] = [
                        "value" => $variable->namespace() . '.' . \Illuminate\Support\Str::slug($label),
                        "label" => $variable->namespace() . '.' . "$label - $description",
                        'title' => $label,
                        "description" => $description,
                    ];
                }
            }
        }


        return view('crmautocar::livewire.send-email-dossier', compact('templates'));
    }
}
