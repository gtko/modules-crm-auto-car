<?php

namespace Modules\CrmAutoCar\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $sexe
 * @property string $company
 * @property string $prenom
 * @property string $nom
 * @property string $email
 * @property string $tel
 * @property string $type
 * @property string $personnes
 * @property string $depart
 * @property string $arrivee
 * @property string $date_dep
 * @property string $date_ret
 *
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
            'personnes' => '',
            'depart' => '',
            'arrivee' => '',
            'date_dep' => '',
            'date_ret' => '',
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
