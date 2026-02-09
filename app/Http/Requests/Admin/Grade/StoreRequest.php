<?php

namespace App\Http\Requests\Admin\Grade;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'       => 'required|string|max:255|unique:grades,name',
            'notes'      => 'nullable|string',
            'status'     => 'required|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ];
    }
}
