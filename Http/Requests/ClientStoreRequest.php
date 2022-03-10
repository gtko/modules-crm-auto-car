<?php

namespace Modules\CrmAutoCar\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $company
 */
class ClientStoreRequest extends \Modules\CoreCRM\Http\Requests\ClientStoreRequest
{
    public function rules(): array
    {
        return  parent::rules() + [
            'company' => 'string|nullable',
        ];
    }
}
