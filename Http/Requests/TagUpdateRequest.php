<?php

namespace Modules\CrmAutoCar\Http\Requests;

use Illuminate\Validation\Rule;

class TagUpdateRequest extends TagsStoreRequest
{
    public function rules()
    {
        return [
            'label' => ['required',  Rule::unique('tags')->ignore($this->route()->tag->id), 'max:255', 'string'],
            'color' => ['required', 'string']
        ];
    }
}
