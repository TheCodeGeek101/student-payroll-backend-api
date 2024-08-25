<?php


namespace App\Containers\SchoolsSection\Assessments\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAssessmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Implement your authorization logic here.
        // For example, check if the user has permission to update the assessment.
        return true; // Set to true for now, adjust based on your authorization logic
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
            'tutor_id' => 'required|exists:tutors,id',
            'term_id' => 'required|exists:terms,id',
            'score' => 'required|numeric|min:0|max:100',
            'total_marks' => 'required|numeric|min:0|max:100',
            'comments' => 'nullable|string|max:255',
            'date' => 'required|date',
        ];
    }

    /**
     * Get custom error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'student_id.required' => 'The student field is required.',
            'student_id.exists' => 'The selected student does not exist.',
            'tutor_id.exists' => 'The tutor field does not exist.',
            'tutor_id.required' => 'The tutor field is required.',
            'subject_id.exists' => 'The selected subject does not exist.',
            'subject_id.required' => 'The subject field is required.',
            'term_id.required' => 'The term field is required.',
            'term_id.exists' => 'The selected term does not exist.',
            'score.required' => 'The score field is required.',
            'score.numeric' => 'The score must be a number.',
            'total_marks.numeric' => 'The marks must be a number.',
            'total_marks.required' => 'The score field is required.',
            'score.min' => 'The score must be at least 0.',
            'score.max' => 'The score must not exceed 100.',
            'total_marks.min' => 'The marks must be at least 0.',
            'total_marks.max' => 'The marks must not exceed 100.',
            'comments.string' => 'The comments must be a string.',
            'comments.max' => 'The comments may not be greater than 255 characters.',
            'date.required' => 'The date field is required.',
            'date.date' => 'The date must be a valid date.',
        ];
    }
}
