<?php

namespace Modules\CrmAutoCar\Http\Requests;

use Modules\BaseCore\Http\Requests\PersonneStoreRequest;

class fournisseurUpdateRequest extends PersonneStoreRequest
{
    public function rules(): array
    {
        return parent::rules() + [
            'tag_ids' => 'array|nullable'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
