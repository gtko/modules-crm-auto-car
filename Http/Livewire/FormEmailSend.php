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
    public $content;
    public $dossier;
    public $prix;
    public $subjectMail;
    public $templates;
    public $template;
    public $fourniseur_ids;

    protected $rules =
        [
            'content' => 'required',
            'subjectMail' => 'required',
            'template' => '',

        ];

    public function mount(DossierRepositoryContract $repDossier, TemplatesRepositoryContract $repTemplate, $devi_id, $fournisseur_id, $dossier, $prix)
    {

        $this->devi_id = $devi_id;
        $this->prix = $prix;
        $this->dossierModel = $repDossier->fetchById($dossier['id']);
        $this->fourniseur_ids = $fournisseur_id;
        $this->templates = $repTemplate->getAll();

        $this->subjectMail = 'Demande de transfert (n°' . $this->dossierModel->ref . ')';
    }

    public function updatedTemplate()
    {
        $repTemplate = app(TemplatesRepositoryContract::class);
        $this->content = $repTemplate->fetchById($this->template)->content ?? '';
        $this->emit('refresh:editor');
    }

    public function store(DevisRepositoryContract $repDevi, FournisseurRepositoryContract $repFournisseur)
    {
        $this->validate();

        $deviModel = $repDevi->fetchById($this->devi_id);

        foreach ($this->fourniseur_ids as $fournis_id)
        {

            $this->fournisseurModel = $repFournisseur->fetchById($fournis_id);
            (new SendRequestFournisseurMail())->send($this->fournisseurModel->email, $this->dossierModel, $this->content, $this->subjectMail);
            $repDevi->sendPriceFournisseur($deviModel, $this->fournisseurModel, $this->prix, Carbon::now());
        }



        $this->emit('update');

        session()->flash('success', 'Email envoyé');

        return redirect('/clients/' . $this->dossier['clients_id'] . '/' . 'dossiers/' . $this->dossier['id']);
    }

    public function render()
    {
        return view('crmautocar::livewire.form-email-send');
    }
}
