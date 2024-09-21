<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Adjust this according to your authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'event_name' => 'sometimes|required|string|max:255',
            'start_date' => 'sometimes|required|date|after_or_equal:today',
            'end_date' => 'sometimes|required|date|after_or_equal:start_date',
            'description' => 'sometimes|nullable|string',
            'location' => 'sometimes|nullable|string|max:255',
            'is_recurring' => 'sometimes|nullable|boolean',
            'recurrence_pattern' => 'sometimes|nullable|string|in:daily,weekly,monthly', // Optional recurrence pattern
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
            'event_name.required' => 'The event name is required.',
            'start_date.required' => 'The start date is required.',
            'end_date.required' => 'The end date is required.',
            'end_date.after_or_equal' => 'The end date must be after or equal to the start date.',
            'recurrence_pattern.in' => 'The recurrence pattern must be one of the following: daily, weekly, or monthly.',
        ];
    }
}
