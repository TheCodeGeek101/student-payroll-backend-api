<?php


namespace App\Containers\SchoolsSection\Grades\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateGradesRequest extends FormRequest
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
            'student_id' => 'sometimes|required|exists:students,id',
            'term_id' => 'sometimes|required|exists:terms,id',
            'score' => 'sometimes|required|numeric|min:0|max:100',
            'total_marks' => 'sometimes|required|numeric|min:0|max:100',
            'graded_at' => 'sometimes|required|date',
            'tutor_id' => 'sometimes|required|exists:tutors,id',
            'subject_id' => 'sometimes|required|exists:subjects,id',
            'include_assessments' => 'nullable|boolean',
            'class_id' => 'sometimes|required|exists:classroom,id',
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
            'score.required' => 'The score is required.',
            'score.numeric' => 'The score must be a number.',
            'score.min' => 'The score must be at least 0.',
            'score.max' => 'The score may not be greater than 100.',
            'total_marks.required' => 'Total marks are required.',
            'total_marks.numeric' => 'Total marks must be a number.',
            'total_marks.min' => 'Total marks must be at least 0.',
            'total_marks.max' => 'Total marks may not be greater than 200.',
            'graded_at.required' => 'The graded at date is required.',
            'graded_at.date' => 'The graded at date must be a valid date.',
        ];
    }
}
