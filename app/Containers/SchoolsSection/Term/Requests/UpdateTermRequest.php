<?php


namespace App\Containers\SchoolsSection\Term\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTermRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Adjust this logic as needed
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:terms,name,' . $this->route('term'),
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
        ];
    }

    /**
     * Get custom error messages for validation errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The term name is required.',
            'name.unique' => 'A term with this name already exists.',
            'start_date.required' => 'The start date is required.',
            'start_date.before' => 'The start date must be before the end date.',
            'end_date.required' => 'The end date is required.',
            'end_date.after' => 'The end date must be after the start date.',
        ];
    }
}
