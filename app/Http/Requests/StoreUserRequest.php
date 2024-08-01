<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'document_number' => [
                'required',
                'numeric',
                Rule::unique('users', 'document_number')
                    ->where(fn ($query) => $query->whereNull('deleted_at')),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')
                    ->where(fn ($query) => $query->whereNull('deleted_at')),
            ],
            'institution' => 'required|string|max:255',
            'role_id' => 'required|exists:roles,id',
        ];
    }
}
