<?php

namespace App\Containers\SchoolsSection\Grades\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreGradesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Update with actual authorization logic if needed
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors()
        ], 422));
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
            'term_id' => 'required|exists:terms,id',
            'score' => 'required|numeric|min:0|max:100',
            'total_marks' => 'required|numeric|min:0|max:100',
            'graded_at' => 'required|date',
            'class_id' => 'required|exists:classroom,id', // Corrected class table name
            'include_assessments' => 'nullable|boolean'
        ];
    }

    /**
     * Get the custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'student_id.required' => 'The student ID is required.',
            'student_id.exists' => 'The selected student ID is invalid.',
            'term_id.required' => 'The term ID is required.',
            'term_id.exists' => 'The selected term ID is invalid.',
            'subject_id.required' => 'The subject ID is required.',
            'subject_id.exists' => 'The selected subject ID is invalid.',
            'score.required' => 'The score is required.',
            'score.numeric' => 'The score must be a number.',
            'score.min' => 'The score must be at least 0.',
            'score.max' => 'The score may not be greater than 100.',
            'total_marks.required' => 'Total marks are required.',
            'total_marks.numeric' => 'Total marks must be a number.',
            'total_marks.min' => 'Total marks must be at least 0.',
            'total_marks.max' => 'Total marks may not be greater than 100.',
            'graded_at.required' => 'The graded date is required.',
            'graded_at.date' => 'The graded date must be a valid date.',
            'class_id.required' => 'The class ID is required.',
            'class_id.exists' => 'The selected class ID is invalid.',
            'teacher_id.required' => 'The teacher ID is required.',
            'teacher_id.exists' => 'The selected teacher ID is invalid.',
            'include_assessments.boolean' => 'The include assessments field must be true or false.'
        ];
    }
}
