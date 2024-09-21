<?php

namespace App\Containers\SchoolsSection\Events\Requests;


use Illuminate\Foundation\Http\FormRequest;

class UpdateCalendarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Update based on your authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'term_id' => 'sometimes|required|exists:terms,id',
            'start_date' => 'sometimes|required|date|after_or_equal:today',
            'end_date' => 'sometimes|required|date|after_or_equal:start_date',
            'description' => 'sometimes|nullable|string',
        ];
    }

    /**
     * Custom messages for validation errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'term_id.required' => 'The term is required.',
            'term_id.exists' => 'The selected term does not exist.',
            'start_date.required' => 'The start date is required.',
            'end_date.required' => 'The end date is required.',
            'end_date.after_or_equal' => 'The end date must be after or equal to the start date.',
        ];
    }
}
