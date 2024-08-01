<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePointRequest extends FormRequest
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
        return [
            'title' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'source' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'geometry_id' => 'required|exists:geometries,id',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'ecoregion_id' => 'required|exists:ecoregions,id',
            'altitude' => 'nullable|numeric',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'observations' => empty($this->observations) ? 'nullable' : 'array|min:1|max:1'
        ];
    }

    public function attributes()
    {
        return [
            'observations' => 'avistamiento'
        ];
    }
}
