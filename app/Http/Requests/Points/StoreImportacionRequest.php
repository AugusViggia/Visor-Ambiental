<?php

namespace App\Http\Requests\Points;

use Illuminate\Foundation\Http\FormRequest;

class StoreImportacionRequest extends FormRequest
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
        $mimes = config('custom.file_uploads.csv_mimes');

        return [
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'ecoregion_id' => 'required|exists:ecoregions,id',
            'file' => "required|file|mimes:$mimes",
        ];
    }

    public function attributes()
    {
        return [
            'file' => 'EL archivo de importación',
        ];
    }
}
