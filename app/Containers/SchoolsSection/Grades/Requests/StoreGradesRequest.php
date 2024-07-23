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
        return true;
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
            'subject_id' => 'required|exists:subjects,id', // Added subject_id for consistency
            'assessments' => 'required|array',
            'assessments.*.grade' => 'required|numeric|min:0|max:100', // Validate each assessment grade
            'assessments.*.weightage' => 'required|numeric|min:0|max:1', // Validate each assessment weightage
            'graded_at' => 'required|date',
            'comments' => 'nullable|string',
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
            'assessments.*.grade.required' => 'Each assessment must have a grade.',
            'assessments.*.grade.numeric' => 'Each assessment grade must be a number.',
            'assessments.*.grade.min' => 'Each assessment grade must be at least 0.',
            'assessments.*.grade.max' => 'Each assessment grade must be at most 100.',
            'assessments.*.weightage.required' => 'Each assessment must have a weightage.',
            'assessments.*.weightage.numeric' => 'Each assessment weightage must be a number.',
            'assessments.*.weightage.min' => 'Each assessment weightage must be at least 0.',
            'assessments.*.weightage.max' => 'Each assessment weightage must be at most 1.',
        ];
    }
}
