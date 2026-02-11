<?php

namespace App\Http\Requests\Admin\Classroom;

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
            'name' => 'required|array',
            'name.ar' => [
                'required','string','max:30',
                Rule::unique('class_rooms', 'name->ar')->where(function ($query) {
                    return $query->where('grade_id', $this->grade_id);
                })->ignore($this->classroom->id),
            ],
            'name.en' => [
                'required','string','max:30',
                Rule::unique('class_rooms', 'name->en')->where(function ($query) {
                    return $query->where('grade_id', $this->grade_id);
                })->ignore($this->classroom->id),
            ],
            'grade_id'   => 'required|integer|exists:grades,id',
            'status'     => 'required|boolean',
            'sort_order' => 'nullable|integer|min:0|max:1000',
            'notes'      => 'nullable|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'name.ar.unique' => __("admin.classrooms.messages.error.name_ar_unique"),
            'name.en.unique' => __("admin.classrooms.messages.error.name_en_unique"),
        ];
    }
}
