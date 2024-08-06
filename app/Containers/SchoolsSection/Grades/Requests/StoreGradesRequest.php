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
            'score' => 'required|numeric|min:0|max:100',
            'total_marks' => 'required|numeric|min:0|max:100',
            'graded_at' => 'required|date'
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
