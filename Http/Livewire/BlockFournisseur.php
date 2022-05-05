<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use App\Http\Requests\FournisseurStoreRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Modules\BaseCore\Actions\Personne\CreatePersonne;
use Modules\BaseCore\Http\Requests\PersonneStoreRequest;
use Modules\BaseCore\Http\Requests\UserStoreRequest;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\FournisseurRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\TagFournisseurRepositoryContract;
use Modules\CoreCRM\Services\FlowCRM;
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierDemandeFournisseurDelete;
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierDemandeFournisseurSend;
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierDemandeFournisseurValidate;
use Modules\CrmAutoCar\Flow\Attributes\DevisSendClient;
use Modules\CrmAutoCar\Http\Requests\fournisseurUpdateRequest;
use Modules\CrmAutoCar\Models\Dossier;


class BlockFournisseur extends Component
{
    public $dossier;
    public $fournisseurs;
    public $tags;
    public $devis;
    public $fournisseur_id;
    public $tag_id;
    public $devi_id;
    public $price = null;
    public $editPrice = false;

    protected $listeners = [
        'update' => '$refresh',
        'blockfournisseur:confirm_send' => 'confirmSend',
    ];

    protected $rules = [
        'fournisseur_id' => 'required_without:tag_id',
        'tag_id' => 'required_without:fournisseur_id',
        'devi_id' => 'required',
    ];
    public bool $add = false;

    public function mount(FournisseurRepositoryContract $repFournisseur, $client, $dossier)
    {
        $this->dossier = $dossier->load('devis');
        $this->fournisseurs = $repFournisseur->getAllList();
        $this->tags = app(TagFournisseurRepositoryContract::class)->all();

        foreach ($dossier->devis as $devi)
        {
            foreach ($devi->fournisseurs as $fourni)
            {
                $this->price[$fourni->id] = $fourni->pivot->prix;
            }
        }

    }



    public function send()
    {
        $this->validate();

        $observables = [];


        foreach(($this->fournisseur_id ?? []) as $fournisseur_id){
            $observables[] = [
                    ClientDossierDemandeFournisseurSend::class,
                    [
                        'user_id' => Auth::id(),
                        'devis_id' => $this->devi_id,
                        'fournisseur_id' => $fournisseur_id,
                    ]
                ];
        }

        $tagRep  = app(TagFournisseurRepositoryContract::class);
        foreach(($this->tag_id ?? []) as $tag_id) {
            $tag = $tagRep->newQuery()->find($tag_id);
            foreach ($tag->fournisseurs as $fournisseur)
            {
                $observables[] = [
                    ClientDossierDemandeFournisseurSend::class,
                    [
                        'user_id' => Auth::id(),
                        'devis_id' => $this->devi_id,
                        'fournisseur_id' => $fournisseur->id,
                    ]
                ];
            }
        }


        $this->emit('send-mail:open', [
            'flowable' => [Dossier::class, $this->dossier->id],
            'observable' => $observables,
            'callback' => 'blockfournisseur:confirm_send',
        ]);


        //$this->emit('popup-mail:open', ['fournisseur_id' => $this->fournisseur_id, 'devi_id' => $this->devi_id, 'dossier' => $this->dossier]);
    }


    protected function createDemande(){
        $repFournisseur = app(FournisseurRepositoryContract::class);
        $repDevi = app(DevisRepositoryContract::class);
        $deviModel = $repDevi->newQuery()->find($this->devi_id);

        \DB::beginTransaction();
        foreach (($this->fournisseur_id ?? []) as $fournis_id) {
            $fournisseurModel = $repFournisseur->fetchById($fournis_id);
            $repDevi->sendDemandeFournisseur($deviModel, $fournisseurModel, Carbon::now());
        }
        \DB::commit();

        \DB::beginTransaction();
        $tagRep  = app(TagFournisseurRepositoryContract::class);
        foreach(($this->tag_id ?? []) as $tag_id) {
            $tag = $tagRep->newQuery()->with('fournisseurs')->find($tag_id);
            foreach ($tag->fournisseurs as $fournisseur) {
                $repDevi->sendDemandeFournisseur($deviModel, $fournisseur, Carbon::now());
            }
        }
        \DB::commit();
    }

    public function createWithoutSend(){
        $this->createDemande();
        return redirect(route('dossiers.show', [$this->dossier->client, $this->dossier]))
            ->with('success', 'Demande créé avec succès');
    }

    public function confirmSend(){
        $this->createDemande();
        return redirect(route('dossiers.show', [$this->dossier->client, $this->dossier]))
            ->with('success', 'Emails envoyé avec succès au(x) fournisseur(s)');
    }

    public function savePrice(DevisRepositoryContract $repDevi, FournisseurRepositoryContract $repFournisseur, int $devisId, int $fournisseurId) {
        if($this->price != null)
        {
            $repDevi->savePriceFournisseur($this->devis, $this->fournisseur, $this->price[$fournisseurId]);
        }
    }

    public function validateDemande(int $devisId, int $fournisseurId, FournisseurRepositoryContract $repFournisseur, DevisRepositoryContract $repDevi)
    {
        if($this->price != null)
        $deviModel = $repDevi->fetchById($devisId);
        $fournisseurModel = $repFournisseur->fetchById($fournisseurId);


        $repDevi->validateFournisseur($deviModel, $fournisseurModel);
        $prix = $repDevi->getPrice($deviModel, $fournisseurModel);

        (new FlowCRM())->add($this->dossier , new ClientDossierDemandeFournisseurValidate(Auth::user(), $deviModel, $fournisseurModel, $prix));

        $this->emit('update');
    }

    public function delete(int $devisId, int $fournisseurId, FournisseurRepositoryContract $repFournisseur, DevisRepositoryContract $repDevi)
    {
        $deviModel = $repDevi->fetchById($devisId);
        $fournisseurModel = $repFournisseur->fetchById($fournisseurId);

        $prix = $repDevi->getPrice($deviModel, $fournisseurModel);

        $repDevi->detachFournisseur($deviModel, $fournisseurModel);
        (new FlowCRM())->add($this->dossier , new ClientDossierDemandeFournisseurDelete(Auth::user(), $deviModel, $fournisseurModel));

        $this->emit('update');
    }

    public function newFournisseur(){
        $this->add = true;
    }

    public function annulerAdd(){
        $this->add = false;
    }

    public string $add_company = '';
    public string $add_firstname = '';
    public string $add_lastname = '';
    public string $add_email = '';
    public string $add_phone = '';


    public function createFournisseur(FournisseurRepositoryContract $repFournisseur){

        $request = new fournisseurUpdateRequest();

        $data = [
            'company' => $this->add_company,
            'firstname' => $this->add_firstname,
            'lastname' => $this->add_lastname,
            'email' => $this->add_email,
            'phone' => $this->add_phone,
        ];

        $request->replace($data);
        try {
            $request->validate(array_merge($request->rules(), ['company' => 'required']));

            if(!$request->firstname) {
                $data = array_merge($data, ['firstname' => $request->company]);
                $request->replace($data);
            }

            if(!$request->astreinte) {
                $data = array_merge($data, ['astreinte' => $request->phone]);
                $request->replace($data);
            }

            $data = array_merge($data, ['email' => [$request->email], 'phone' => [$request->phone]]);
            $request->replace($data);

            $personne = (new CreatePersonne())->create($request);

            $data = [
                'company' => $this->add_company,
                'enabled' => true,

            ];

            $fournisseur = $repFournisseur->create($personne, $data);
            $this->add = false;

            return redirect()->route('dossiers.show', [$this->dossier->client, $this->dossier])
                ->with('success', 'Fournisseur créé avec succès');

        }catch( ValidationException $e){
            foreach ($e->errors() as $name => $message) {
                foreach($message as $msg) {
                    $this->addError($name, $msg);
                }
            }
        }


    }

    public function render(FournisseurRepositoryContract $repFournisseur)
    {

        $this->dossier = app(DossierRepositoryContract::class)->newquery()->where('id', $this->dossier->id)->first();
        $this->fournisseurs = $repFournisseur->getAllList();
        $this->tags = app(TagFournisseurRepositoryContract::class)->all();

        foreach ($this->dossier->devis as $devi)
        {
            foreach ($devi->fournisseurs as $fourni)
            {
                $this->price[$fourni->id] = $fourni->pivot->prix;
            }
        }

        foreach ($this->dossier->devis as $devi) {
//            if($devi->validate) {
                $this->devis[$devi->id] = $devi;
//            }
        }
        return view('crmautocar::livewire.block-fournisseur');
    }
}
