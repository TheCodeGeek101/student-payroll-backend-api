<?php

namespace App\Containers\FinancialSection\Payments\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            'student_id' => 'required|exists:students,id',
            'class_id' => 'required|exists:classroom,id',
            'term_id' => 'required|exists:terms,id',
            'amount' => 'required|numeric|min:1000',
            'payment_date' => 'required|date',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'currency' => 'requried | string'
        ];
    }
}
