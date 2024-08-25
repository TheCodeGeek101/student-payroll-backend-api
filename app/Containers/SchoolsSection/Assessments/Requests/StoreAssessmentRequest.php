<?php


namespace App\Containers\SchoolsSection\Assessments\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssessmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // You can add authorization logic here if needed
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'student_id' => 'required|exists:students,id',
            'term_id' => 'required|exists:terms,id',
            'score' => 'required|numeric|min:0|max:100',
            'total_marks' => 'required|numeric|min:0|max:100',
            'comments' => 'nullable|string|max:255',
            'date' => 'required|date',
        ];
    }

    /**
     * Get custom error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'student_id.required' => 'The student field is required.',
            'student_id.exists' => 'The selected student does not exist.',
            'term_id.required' => 'The term field is required.',
            'term_id.exists' => 'The selected term does not exist.',
            'score.required' => 'The score field is required.',
            'score.numeric' => 'The score must be a number.',
            'score.min' => 'The score must be at least 0.',
            'score.max' => 'The score must not exceed 100.',
            'comments.string' => 'The comments must be a string.',
            'comments.max' => 'The comments may not be greater than 255 characters.',
            'date.required' => 'The date field is required.',
            'date.date' => 'The date must be a valid date.',
        ];
    }
}
