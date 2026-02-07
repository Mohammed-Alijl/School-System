<?php

namespace App\Http\Requests\Admin\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'name' => ['required','string','max:30','min:3',Rule::unique('admins')->ignore($this->route('admin'))],
            'email' => ['required','email','max:255',Rule::unique('admins', 'email')->ignore($this->route('admin'))],
            'password' => 'nullable|confirmed|min:8|max:30',
            'roles_name' => 'required|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:0,1',
        ];
    }
}
