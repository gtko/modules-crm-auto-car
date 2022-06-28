<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\BaseCore\Actions\Url\SigneRoute;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Services\FlowCRM;
use Modules\CrmAutoCar\Contracts\Repositories\BrandsRepositoryContract;
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierDevisClientSaveValidation;
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierDevisValidation;

class ValidationInformationVoyage extends Component
{

    public $devis;
    public $multiple = false;

    public $waiting = false;

    public array $validate = [];

    protected $rules = [
        'validate.*.contact_nom' => 'required',
        'validate.*.contact_prenom' => 'required',
        'validate.*.tel_1' => 'required',
        'validate.*.tel_2' => '',
        'validate.*.aller_date_depart' => 'required',
        'validate.*.aller_pax' => 'required',
        'validate.*.addresse_ramassage' => 'required',
        'validate.*.retour_date_depart' => 'required',
        'validate.*.retour_pax' => 'required',
        'validate.*.addresse_destination' => 'required',

    ];

    protected $listeners = ['devis:update-address' => 'updateAddress'];

    public function mount(DevisEntities $devis){
        $this->devis = $devis;
        if(count($this->devis->data['trajets'] ?? []) > 1) {
            $this->multiple = true;
        }

        if($this->devis->data['validate'] ?? false){
            $this->validate = $this->devis->data['validate'];
            if(!($this->devis->data['validated'] ?? false)){
                $this->waiting = true;
            }
        }else{
            foreach($this->devis->data['trajets'] ?? [] as $idTrajet => $trajet)
            $this->validate[$idTrajet] = [
                'aller_date_depart' => $trajet['aller_date_depart'] ?? '',
                'aller_pax' => $trajet['aller_pax'] ?? '',
                'addresse_ramassage' => $trajet["addresse_ramassage"] ?? '',
                'retour_date_depart' => $trajet["retour_date_depart"] ?? '',
                'retour_pax' => $trajet["retour_pax"] ?? '',
                'addresse_destination' => $trajet["addresse_destination"] ?? '',

                'addresse_ramassage_retour' => $trajet["addresse_ramassage_retour"] ?? '',
                'addresse_destination_retour' => $trajet["addresse_destination_retour"] ?? '',

                'contact_nom' => '',
                'contact_prenom' => '',
                'tel_1' => '',
                'tel_2' => '',
                'information_complementaire' => ''
            ];
        }

    }

    public function store(){

        $this->validate($this->rules, [], [
            'validate.*.contact_nom' => 'nom du contact',
            'validate.*.contact_prenom' => 'prenom du contact',
            'validate.*.tel_1' => 'téléphone 1',
            'validate.*.tel_2' => 'téléphone 2',
            'validate.*.aller_date_depart' => 'date de départ',
            'validate.*.aller_pax' => 'nombre de participant',
            'validate.*.addresse_ramassage' => 'adresse de pris en charge',
            'validate.*.retour_date_depart' => 'date de retour',
            'validate.*.retour_pax' => 'nombre de participant',
            'validate.*.addresse_destination' => 'adresse de ramassage',
            'validate.*.retour_aller_date_depart' => 'date de départ',
            'validate.*.retour_aller_pax' => 'nombre de participant',
            'validate.*.addresse_ramassage_retour' => 'adresse de pris en charge',
            'validate.*.retour_retour_date_depart' => 'date de retour',
            'validate.*.retour_retour_pax' => 'nombre de participant',
            'validate.*.addresse_destination_retour' => 'adresse de ramassage',
        ]);

        $data = $this->devis->data;
        $data['validate'] = $this->validate;
        $data['validated'] = false;
        $this->devis->data = $data;
        $this->devis->save();

        (new FlowCRM())->add($this->devis->dossier,new ClientDossierDevisClientSaveValidation($this->devis));

        session()->flash('success', 'Vos informations voyage ont été prise en compte, merci.');

        return $this->redirect((new SigneRoute())->signer('validation-voyage', $this->devis));
    }

    public function updateAddress($params){
        $this->validate[$params['id']][$params['name']] = $params['format'];
    }

    public function render()
    {
        $brand = app(BrandsRepositoryContract::class)->getDefault();
        return view('crmautocar::livewire.validation-information-voyage', compact('brand'));
    }
}
