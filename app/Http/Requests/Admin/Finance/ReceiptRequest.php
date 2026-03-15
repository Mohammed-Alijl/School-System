<?php

namespace App\Http\Requests\Admin\Finance;

use Illuminate\Foundation\Http\FormRequest;

class ReceiptRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('admin')->user()->can('create_receipts');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'student_id'         => 'required|integer|exists:students,id',
            'academic_year_id'   => 'required|integer|exists:academic_years,id',
            'payment_gateway_id' => 'required|integer|exists:payment_gateways,id',
            'paid_amount'        => 'required|numeric|min:10.0|max:10000.0',
            'currency_code'      => 'required|string|size:3|exists:currencies,code',
            'transaction_id'     => 'nullable|string|max:255',
            'date'               => 'nullable|date',
            'description'        => 'nullable|string|max:1000',
        ];
    }
}
