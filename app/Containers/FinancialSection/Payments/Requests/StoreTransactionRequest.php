<?php


namespace App\Containers\FinancialSection\Payments\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
    public function rules()
    {
        return [
            'student_id' => 'required|exists:students,id',
            'event_type' => 'required|string',
            'tx_ref' => 'required|string|unique:payments,tx_ref',
            'mode' => 'required|string',
            'type' => 'required|string',
            'status' => 'required|string',
            'number_of_attempts' => 'required|integer',
            'reference' => 'required|string|unique:payments,reference',
            'currency' => 'required|string',
            'amount' => 'required|numeric',
            'charges' => 'required|numeric',
            'customization.title' => 'required|string',
            'customization.description' => 'required|string',
            'meta.uuid' => 'required|string',
            'meta.response' => 'required|string',
            'authorization.channel' => 'required|string',
            'authorization.provider' => 'required|string',
            'authorization.mobile_number' => 'required|string',
            'authorization.completed_at' => 'required|date',
            'customer.email' => 'required|email',
            'customer.first_name' => 'required|string',
            'customer.last_name' => 'required|string',
            'logs' => 'nullable|array',
            'logs.*.type' => 'required|string',
            'logs.*.message' => 'required|string',
            'logs.*.created_at' => 'required|date',
        ];
    }
}
