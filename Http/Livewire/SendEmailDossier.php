<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\CoreCRM\Contracts\Services\FlowContract;
use Modules\CoreCRM\Flow\Works\Actions\ActionsSendNotification;
use Modules\CoreCRM\Flow\Works\Files\WorkFlowAttachments;
use Modules\CoreCRM\Models\Flow;
use Modules\CrmAutoCar\Contracts\Repositories\TemplatesRepositoryContract;
use Modules\CrmAutoCar\Flow\Works\Events\EventSendEmailDossier;

class SendEmailDossier extends Component
{

    use WithFileUploads;

    public $dossier;
    public $client;

    public $preview = false;

    public $variableData = [];

    public $email = [
        'subject' => '',
        'sender' => '{utilisateur.email}',
        'body' => '',
        'template' => '',
        'model' => '',
        'cc' => '{client.email}',
        'cci' => '',
        ''
    ];

    public $files = [];

    public $rules = [
        'email.subject' => 'required',
        'email.sender' => 'required',
        'email.body' => 'required',
        'email.template' => 'required',
        'email.cc' => 'required',
        'email.cci' => '',
        'files' => '',
    ];

    public function mount($dossier, $client){
        $this->dossier = $dossier;
        $this->client = $client;
    }

    public function updatedEmailModel($field, $value){
        $template = app(TemplatesRepositoryContract::class)->fetchById($this->email['model']);
        $this->email['subject'] = $template->subject;
        $this->email['body'] = $template->content;
        $this->emit('changeWysiwyg');
    }

    public function preview(){
        $this->preview = true;
    }

    public function editer(){
        $this->preview = false;
    }

    public function getSubjectPreviewProperty(){
        return $this->resolveAction()->resolveDatas()['subject'];
    }

    public function getEmailPreviewProperty(){
        return $this->resolveAction()->preview();
    }

    public function send(){
        $instanceAction = $this->resolveAction();
        $instanceAction->sendEmail();

        app(FlowContract::class)->add(
            $this->dossier,
            (
                new \Modules\CrmAutoCar\Flow\Attributes\SendEmailDossier($this->dossier, Auth::user(), $this->email)
            )
        );

        session()->flash('success', "Envoie de l'email avec succès");

        return $this->redirect(route('dossiers.show', [$this->client, $this->dossier, 'tab' => 'email']));

    }

    protected function resolveAction(): ActionsSendNotification
    {
        $attribute =  new \Modules\CrmAutoCar\Flow\Attributes\SendEmailDossier($this->dossier, Auth::user(), $this->email);

        $event = app(EventSendEmailDossier::class);
        $flow = new Flow();
        $flow->datas = $attribute;
        $event->init($flow);

        //traitement des pièces jointes
        $attachments = [];
        foreach($this->files as $attachment){
            $content = file_get_contents($attachment->getRealPath());
            $attachments[] = (new WorkFlowAttachments($content, $attachment->getClientOriginalName(), $attachment->getMimeType()));
        }

        $instanceAction = $event->makeAction(ActionsSendNotification::class);
        $instanceAction->initParams([[
            'subject' => $this->email['subject'],
            'cc' => '{commercial.email}',
            'cci' => $this->email['cci'],
            'from' => $this->email['sender'],
            'files' => $attachments,
            'content' => $this->email['body'],
            'template' => 'default',
        ]]);

        return $instanceAction;
    }

    public function render()
    {
        $templates = app(TemplatesRepositoryContract::class)->all();

        $workflowEvent = new EventSendEmailDossier();
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
