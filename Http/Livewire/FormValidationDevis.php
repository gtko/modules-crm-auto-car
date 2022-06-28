<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Flow\Attributes\ClientDossierNoteCreate;
use Modules\CoreCRM\Services\FlowCRM;
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierDevisValidation;

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
                    'addresse_destination' => $trajetValid["addresse_destination"] ?? '',
                    'retour_date_depart' => $trajetValid["retour_date_depart"] ?? '',
                    'retour_pax' => $trajetValid["retour_pax"] ?? '',
                    'addresse_ramassage_retour' => $trajetValid["addresse_ramassage_retour"] ?? '',
                    'addresse_destination_retour' => $trajetValid["addresse_destination_retour"] ?? '',
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
                    'addresse_destination' => $trajetInit["addresse_destination"] ?? '',
                    'retour_date_depart' => $trajetInit["retour_date_depart"] ?? '',
                    'retour_pax' => $trajetInit["retour_pax"] ?? '',
                    'addresse_ramassage_retour' => $trajetInit["addresse_ramassage_retour"] ?? '',
                    'addresse_destination_retour' => $trajetInit["addresse_destination_retour"] ?? '',
                    'contact_nom' => $trajetInit["contact_nom"] ?? '',
                    'contact_prenom' => $trajetInit["contact_prenom"] ?? '',
                    'tel_1' => $trajetInit["tel_1"] ?? '',
                    'tel_2' => $trajetInit["tel_2"] ?? '',
                    'information_complementaire' => $trajetInit["information_complementaire"] ?? ''
                ];
            }


            $this->delta = [];
            foreach ($this->devis->data['trajets'] ?? [] as $id => $trajetValid) {
                $this->delta [$id] = [];
                foreach ($this->validate[$id] as $key => $value) {
                    $this->delta[$id][$key] = $this->validate[$id][$key] === $this->initiale[$id][$key];
                }
            }

            $this->data = collect([$this->validate, $this->initiale]);

        }
    }

    public function close()
    {
        $this->emit('popup-validation-devis:close');
    }

    public function valider()
    {
        $data = $this->devis->data;
        $keys = ['trajets', 'validate' ];
//        foreach ($data['trajets'] as $id =>  $trajet)
//        {
//            foreach ($keys as $key)
//            {
//                Arr::set($data, "$key.$id.aller_date_depart", $this->validate[$id]['aller_date_depart']);
//                Arr::set($data, "$key.$id.aller_pax", $this->validate[$id]['aller_pax']);
//                Arr::set($data, "$key.$id.addresse_ramassage", $this->validate[$id]['addresse_ramassage']);
//                Arr::set($data, "$key.$id.addresse_destination", $this->validate[$id]['addresse_destination']);
//                Arr::set($data, "$key.$id.retour_date_depart", $this->validate[$id]['retour_date_depart']);
//                Arr::set($data, "$key.$id.retour_pax", $this->validate[$id]['retour_pax']);
//                Arr::set($data, "$key.$id.addresse_ramassage_retour", $this->validate[$id]['addresse_ramassage_retour']);
//                Arr::set($data, "$key.$id.addresse_destination_retour", $this->validate[$id]['addresse_destination_retour']);
//                Arr::set($data, "$key.$id.contact_nom", $this->validate[$id]['contact_nom']);
//                Arr::set($data, "$key.$id.contact_prenom", $this->validate[$id]['contact_prenom']);
//                Arr::set($data, "$key.$id.tel_1", $this->validate[$id]['tel_1']);
//                Arr::set($data, "$key.$id.tel_2", $this->validate[$id]['tel_2']);
//                Arr::set($data, "$key.$id.information_complementaire", $this->validate[$id]['information_complementaire']);
//            }
//        }
        Arr::set($data, "validated", true);

        app(DevisRepositoryContract::class)->updateData($this->devis, $data);
        $this->emit('popup-validation-devis:close');
        $this->emit('refreshStatusDevis');

        (new FlowCRM())->add($this->devis->dossier,new ClientDossierDevisValidation(Auth::user(), $this->devis));

        session()->flash('success', 'Votre devis a été validé');
    }

    public function render()
    {

        return view('crmautocar::livewire.form-validation-devis');
    }
}
