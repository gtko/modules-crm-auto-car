<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\FournisseurRepositoryContract;
use Modules\CrmAutoCar\Actions\SendRequestFournisseurMail;
use Modules\CrmAutoCar\Contracts\Repositories\TemplatesRepositoryContract;
use Modules\CrmAutoCar\Mail\RequestFournisseurMail;

class FormEmailSend extends Component
{
    public $fournisseurModel;
    public $dossierModel;
    public $devi_id;
    public $email;
    public $content;
    public $dossier;
    public $prix;
    public $subjectMail;
    public $templates;
    public $template;

    protected $rules =
        [
            'content' => 'required',
            'email' => 'required',
            'subjectMail' => 'required',
            'template' => '',

        ];

    public function mount(FournisseurRepositoryContract $repFournisseur, DossierRepositoryContract $repDossier, TemplatesRepositoryContract $repTemplate, $devi_id, $fournisseur_id, $dossier, $prix)
    {
        $this->devi_id = $devi_id;

        $this->prix = $prix;

        $this->dossierModel = $repDossier->fetchById($dossier['id']);
        $this->fournisseurModel = $repFournisseur->fetchById($fournisseur_id);
        $this->templates = $repTemplate->getAll();



        $this->subjectMail = 'Demande de transfert (n°' . $this->dossierModel->ref . ')';
    }

    public function updatedTemplate()
    {
        $this->content = $this->template;
    }

    public function store (DevisRepositoryContract $repDevi)
    {
        $this->validate();

        $deviModel = $repDevi->fetchById($this->devi_id);

        (new SendRequestFournisseurMail())->send($this->email, $this->dossierModel, $this->content, $this->subjectMail);

        $repDevi->sendPriceFournisseur($deviModel, $this->fournisseurModel, $this->prix, Carbon::now());

        $this->emit('update');

        session()->flash('success', 'Email envoyé');

        return redirect('/clients/' . $this->dossier['clients_id'] . '/' . 'dossiers/' . $this->dossier['id']);
    }

    public function render()
    {
        return view('crmautocar::livewire.form-email-send');
    }
}
