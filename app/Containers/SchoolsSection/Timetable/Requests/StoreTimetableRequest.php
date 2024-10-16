<?php

namespace App\Containers\SchoolsSection\Timetable\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTimetableRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // You can add logic here for authorization if needed
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'subject_id' => 'required|exists:subjects,id',
            'tutor_id' => 'required|exists:tutors,id',
            'day_of_week' => 'required|string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'class_id' => 'nullable|exists:classroom,id',
        ];
    }

    /**
     * Custom error messages for validation.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'subject_id.required' => 'The subject is required.',
            'subject_id.exists' => 'The selected subject does not exist.',
            'tutor_id.required' => 'The tutor is required.',
            'tutor_id.exists' => 'The selected tutor does not exist.',
            'day_of_week.required' => 'The day of the week is required.',
            'day_of_week.in' => 'The selected day of the week is invalid.',
            'start_time.required' => 'The start time is required.',
            'start_time.date_format' => 'The start time format is invalid. Use HH:MM.',
            'end_time.required' => 'The end time is required.',
            'end_time.date_format' => 'The end time format is invalid. Use HH:MM.',
            'end_time.after' => 'The end time must be after the start time.',
            'class_id.exists' => 'The selected classroom does not exist.',
        ];
    }
}
