<?php

namespace App\Containers\SchoolsSection\Class\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClassroomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Implement your authorization logic as needed
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'schedule' => 'nullable|json',
            'term' => 'required|string|max:100',
            'capacity' => 'nullable|integer|min:1',
            'subject_id' => 'nullable|exists:subjects,id',
            'room' => 'nullable|string|max:100',
            'status' => 'required|string|in:Active,Cancelled'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The class name is required.',
            'name.string' => 'The class name must be a string.',
            'name.max' => 'The class name may not be greater than 255 characters.',
            'description.string' => 'The description must be a string.',
            'schedule.json' => 'The schedule must be a valid JSON string.',
            'term.required' => 'The term is required.',
            'term.string' => 'The term must be a string.',
            'term.max' => 'The term may not be greater than 100 characters.',
            'capacity.integer' => 'The capacity must be an integer.',
            'capacity.min' => 'The capacity must be at least 1.',
            'subject_id.exists' => 'The selected subject does not exist.',
            'room.string' => 'The room must be a string.',
            'room.max' => 'The room may not be greater than 100 characters.',
            'status.required' => 'The status is required.',
            'status.string' => 'The status must be a string.',
            'status.in' => 'The status must be either Active or Cancelled.'
        ];
    }
}
