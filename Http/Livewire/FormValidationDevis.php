<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;

class FormValidationDevis extends Component
{
    public $devis;
    public $validate;
    public $initiale;
    public $delta;
    public $data;

    public function mount($devi_id)
    {
        $this->devis = app(DevisRepositoryContract::class)->fetchById($devi_id);

        if (count($this->devis->data['trajets'] ?? []) > 1) {
            $this->multiple = true;
        }

        if ($this->devis->data['validate'] ?? false) {

            foreach ($this->devis->data['validate'] ?? [] as $idTrajet => $trajetValid) {
                $this->validate[$idTrajet] = [
                    'aller_date_depart' => $trajetValid['aller_date_depart'] ?? '',
                    'aller_pax' => $trajetValid['aller_pax'] ?? '',
                    'addresse_ramassage' => $trajetValid["addresse_ramassage"] ?? '',
                    'retour_date_depart' => $trajetValid["retour_date_depart"] ?? '',
                    'retour_pax' => $trajetValid["retour_pax"] ?? '',
                    'addresse_destination' => $trajetValid["addresse_destination"] ?? '',
                    'contact_nom' => $trajetValid["contact_nom"] ?? '',
                    'contact_prenom' => $trajetValid["contact_prenom"] ?? '',
                    'tel_1' => $trajetValid["tel_1"] ?? '',
                    'tel_2' => $trajetValid["tel_2"] ?? '',
                    'information_complementaire' => $trajetValid["information_complementaire"] ?? ''
                ];
            }

            foreach ($this->devis->data['trajets'] ?? [] as $id => $trajetInit) {
                $this->initiale[$id] = [
                    'aller_date_depart' => $trajetInit['aller_date_depart'] ?? '',
                    'aller_pax' => $trajetInit['aller_pax'] ?? '',
                    'addresse_ramassage' => $trajetInit["addresse_ramassage"] ?? '',
                    'retour_date_depart' => $trajetInit["retour_date_depart"] ?? '',
                    'retour_pax' => $trajetInit["retour_pax"] ?? '',
                    'addresse_destination' => $trajetInit["addresse_destination"] ?? '',
                    'contact_nom' => $this->validate[$id]["contact_nom"] ?? '',
                    'contact_prenom' => $this->validate[$id]["contact_prenom"] ?? '',
                    'tel_1' => $this->validate[$id]["tel_1"] ?? '',
                    'tel_2' => $this->validate[$id]["tel_2"] ?? '',
                    'information_complementaire' => $this->validate[$id]["information_complementaire"] ?? ''
                ];
            }


            $this->delta = [];
            foreach ($this->devis->data['trajets'] ?? [] as $id => $trajetValid) {
                $this->delta [$id] = [];
               foreach( $this->validate[$id] as $key => $value){
                   $this->delta[$id][$key] = $this->validate[$id][$key] === $this->initiale[$id][$key];
               }
            }

            $this->data = collect([$this->validate, $this->initiale]);

        }
    }

    public function render()
    {

        return view('crmautocar::livewire.form-validation-devis');
    }
}
