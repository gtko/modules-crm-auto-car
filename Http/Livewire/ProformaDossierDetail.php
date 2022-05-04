<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Models\Dossier;
use Modules\CrmAutoCar\Flow\Attributes\SendInformationVoyageMailClient;
use Modules\CrmAutoCar\Flow\Attributes\SendProformat;
use Modules\CrmAutoCar\Models\Proformat;

class ProformaDossierDetail extends Component
{
    public $proformat;
    public $dossier;
    public $client;
    public $commercial;
    public $editDate = false;

    public $acceptation_date = '';

    protected $rules = [
        'acceptation_date' => 'date',
    ];

    protected $listeners =
        [
            'refreshProforma' => '$refresh'
        ];

    public function getListeners()
    {
        return [
            'sendProformat:confirm_'.$this->proformat->id => 'confirm',
            'SendInformationVoyageMailClient:confirm_'.$this->proformat->id => 'confirmInfo'
        ];
    }

    public function mount(Proformat $proforma, ClientEntity $client, Dossier $dossier)
    {
        $this->proformat = $proforma;
        $this->client = $client;
        $this->dossier = $dossier;
        $this->commercial = $proforma->devis->commercial->id;
        if($this->proformat->acceptation_date) {
            //2022-08-15T09:00
            $this->acceptation_date = $this->proformat->acceptation_date->format('Y-m-d\TH:i');
        }
    }

    public function saveAcception(){

        $this->validate();

        $this->proformat->acceptation_date = $this->acceptation_date;
        $this->proformat->save();
        $this->closeEditDate();
    }

    public function editDate(){
       $this->editDate = true;
    }

    public function closeEditDate(){
        $this->editDate = false;
    }

    public function sendInformationVoyage(){
        $flowable = $this->dossier;
        $this->emit('send-mail:open', [
            'flowable' => [\Modules\CrmAutoCar\Models\Dossier::class, $this->dossier->id],
            'observable' => [
                [
                    SendInformationVoyageMailClient::class,
                    [
                        'proforma_id' => $this->proformat->id,
                        'user_id' => Auth::user()->id,
                    ]
                ]
            ],
            'callback' => 'SendInformationVoyageMailClient:confirm_'.$this->proformat->id
        ]);
    }

    public function sendProformat(){
        $flowable = $this->dossier;
        $this->emit('send-mail:open', [
            'flowable' => [\Modules\CrmAutoCar\Models\Dossier::class, $this->dossier->id],
            'observable' => [
                [
                    SendProformat::class,
                    [
                        'proformat_id' => $this->proformat->id,
                        'user_id' => Auth::user()->id,
                    ]
                ]
            ],
            'callback' => 'sendProformat:confirm_'.$this->proformat->id
        ]);

    }


    public function confirm(){
        $flowable = $this->dossier;
        session()->flash('success', 'Proforma envoyé au client');
        return redirect()->route('dossiers.show', [$flowable->client, $flowable, 'tab' => 'proforma']);
    }

    public function confirmInfo(){
        $flowable = $this->dossier;
        session()->flash('success', 'Informations voyage envoyé au client');
        return redirect()->route('dossiers.show', [$flowable->client, $flowable, 'tab' => 'proforma']);
    }

    public function save()
    {
        if (Auth::user()->cannot('changeCommercial', Proformat::class)) {
            abort(403);
        }

        $commercial = app(CommercialRepositoryContract::class)->fetchById($this->commercial);
        app(DevisRepositoryContract::class)->changeCommercial($this->proformat->devis, $commercial);
    }

    public function delete(){
        if (Auth::user()->cannot('delete', Proformat::class)) {
            abort(403);
        }

        if($this->proformat->payments->count() > 0 || $this->proformat->devis->invoice){
            session()->flash('error', 'Impossible de supprimer la proforma car il a des paiements ou une facture accroché');
            return redirect()->route('dossiers.show', [$this->dossier->client, $this->dossier, 'tab' => 'proforma']);
        }else {
            $this->proformat->delete();
        }

        session()->flash('success', 'Suppression de la proformat');
        return redirect()->route('dossiers.show', [$this->proformat->devis->dossier->client, $this->proformat->devis->dossier, 'tab' => 'proforma']);
    }

    public function render()
    {
        $commercials = [];
        if (Auth::user()->can('changeCommercial', Proformat::class)) {
            $commercials = app(CommercialRepositoryContract::class)->fetchAll();
        }

        $validate = false;
        foreach ($this->proformat->devis->fournisseurs as $fourni)
        {
            if ($fourni->pivot->validate ?? false) {
                $validate = true;
            }
        }

        return view('crmautocar::livewire.proforma-dossier-detail',
            [
                'commercials' => $commercials,
                'validate' => $validate,
            ]);
    }
}
