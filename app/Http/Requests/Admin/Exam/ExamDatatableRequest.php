<?php

namespace App\Http\Requests\Admin\Exam;

use Illuminate\Foundation\Http\FormRequest;

class ExamDatatableRequest extends FormRequest
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
            'academic_year_id' => 'nullable|integer|exists:academic_years,id',
            'grade_id'         => 'nullable|integer|exists:grades,id',
            'classroom_id'     => 'nullable|integer|exists:class_rooms,id',
            'section_id'       => 'nullable|integer|exists:sections,id',
        ];
    }
}
