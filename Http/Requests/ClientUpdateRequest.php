<?php

namespace Modules\CrmAutoCar\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientUpdateRequest extends \Modules\CoreCRM\Http\Requests\ClientUpdateRequest
{
    public function rules(): array
    {
        return parent::rules() + [
            'company' => 'string|nullable',
        ];
    }
}
