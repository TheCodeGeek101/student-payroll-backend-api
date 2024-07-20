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
            'subject_id' => 'required|exists:subjects,id',
            'grade' => 'required|string|max:5',
            'comments' => 'nullable|string',
            'graded_at' => 'required|date',
        ];
    }
}
