<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreObservationRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'date' => ['required', 'date_format:Y-m-d', 'before_or_equal:' . date('Y-m-d')],
            'taxa' => 'nullable|numeric|min:1',
            'description' => 'required|string|max:255'
        ];

        if ($this->point) {
            array_push($rules['date'], Rule::unique('observations', 'date')
                ->where(fn ($query) => $query->where('point_id', $this->point->id)));
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'date.before_or_equal' => 'Fecha debe ser anterior o igual a hoy.',
            'description.max' => 'La cantidad de caracteres  no debe ser mayor a 255.'
        ];
    }
}
