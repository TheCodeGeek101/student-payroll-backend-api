<?php

namespace App\Containers\SchoolsSection\Events\Requests;


use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Update this if you have authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'event_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_recurring' => 'required|boolean',
            'recurrence_pattern' => 'nullable|string|in:daily,weekly,monthly', // Optional field
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
        ];
    }
}
