<?php

namespace Modules\CrmAutoCar\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\BaseCore\Http\Requests\PersonneStoreRequest;

/**
 * Class PersonneStoreRequest
 * @property $company
 * @property $astreinte
 * @property $firstname
 * @property $lastname
 * @property $date_birth
 * @property $gender
 * @property $email
 * @property $address
 * @property $city
 * @property $code_zip
 * @property $country_id
 * @property $phone
 * @package Modules\BaseCore\Http\Requests
 */
class fournisseurUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'company' => ['nullable', 'min:2', 'max:255', 'string'],
            'astreinte' => ['nullable', 'min:2', 'max:255', 'string'],
            'firstname' => ['nullable', 'min:2', 'max:255', 'string'],
            'lastname' => ['nullable', 'max:255', 'string'],
            'email' => ['required'],
            'address' => [],
            'city' => [],
            'code_zip' => [],
            'country_id' => ['exists:countries,id'],
            'phone' => [],
            'tag_ids' => 'array|nullable'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
