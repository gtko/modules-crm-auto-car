<?php

namespace Modules\CrmAutoCar\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $sexe
 * @property string $company
 * @property string $prenom
 * @property string $nom
 * @property string $email
 * @property string $commercial_email
 * @property string $tel
 * @property string $type
 * @property string $personnes
 * @property string $depart
 * @property string $arrivee
 * @property string $date_dep
 * @property string $date_ret
 * @property string $pax_dep
 * @property string $pax_ret
 * @property string $type_trajet
 *
 */
class EndpointRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'sexe' => '',
            'company' => '',
            'prenom' => 'required',
            'nom' => 'required',
            'email' => 'required',
            'tel' => 'required',
            'type' => '',
            'commercial_email' => '',
            'personnes' => '',
            'depart' => '',
            'arrivee' => '',
            'date_dep' => '',
            'date_ret' => '',
            'pax_dep' => '',
            'pax_ret' => '',
            'type_trajet' => '', //aller , retour, aller retour
            'adresse' => '',
            'ville' => '',
            'code_postal' => '',
            'pays' => 'integer', //demander la table de mapping d'ID
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
