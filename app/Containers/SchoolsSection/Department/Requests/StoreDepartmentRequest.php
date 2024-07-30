<?php
namespace App\Containers\SchoolsSection\Department\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
// You can add logic here to check if the user has permission to create a department.
// For simplicity, we return true to allow all users.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:departments,name',
            'code' => 'required|string|max:10|unique:departments,code',
            'head_of_department' => 'nullable|exists:tutors,id', // Assuming head_of_department refers to the tutor's ID
            'description' => 'nullable|string',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The department name is required.',
            'name.unique' => 'The department name must be unique.',
            'code.required' => 'The department code is required.',
            'code.unique' => 'The department code must be unique.',
            'head_of_department.exists' => 'The selected head of department must exist in the system.',
        ];
    }
}
