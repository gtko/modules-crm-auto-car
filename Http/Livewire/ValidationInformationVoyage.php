<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CrmAutoCar\Contracts\Repositories\BrandsRepositoryContract;

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
        ]);

        $data = $this->devis->data;
        $data['validate'] = $this->validate;
        $data['validated'] = false;
        $this->devis->data = $data;
        $this->devis->save();

        session()->flash('success', 'Vos informations voyage ont été prise en compte, merci.');

        return $this->redirect(route('validation-voyage', $this->devis));
    }

    public function updateAddress($params){
        $this->validate[$params['id']][$params['name']] = $params['format'];
    }

    public function render()
    {
        $brand = app(BrandsRepositoryContract::class)->fetchById(config('crmautocar.brand_default'));
        return view('crmautocar::livewire.validation-information-voyage', compact('brand'));
    }
}
