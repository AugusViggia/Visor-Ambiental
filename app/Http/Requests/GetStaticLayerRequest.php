<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetStaticLayerRequest extends FormRequest
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
        $availables = collect(config('custom.map.statics_layer_sources'));
        return [
            'id' => [
                'required',
                'string',
                'max:255',
                Rule::in($availables->pluck('id')),
            ],
            'load' => [
                'nullable',
                'boolean',
            ],
        ];
    }
}
