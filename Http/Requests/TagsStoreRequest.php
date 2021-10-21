<?php

namespace Modules\CrmAutoCar\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $label
 * @property int $weight
 * @property string $color
 */
class TagsStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'label' => ['required', 'unique:tags', 'max:255', 'string'],
            'color' => ['required', 'string']
        ];
    }
}
