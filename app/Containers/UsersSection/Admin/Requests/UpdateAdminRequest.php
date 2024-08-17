<?php


namespace App\Containers\UsersSection\Admin\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'full_name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:adminstrators,email,' . $this->route('admin'),
            'phone_number' => 'sometimes|string|max:20|unique:adminstrators,phone_number,' . $this->route('admin'),
            'date_of_birth' => 'sometimes|date',
            'gender' => 'sometimes|in:Male,Female,Other',
            'street' => 'sometimes|string|max:255',
            'city' => 'sometimes|string|max:255',
            'state' => 'sometimes|string|max:255',
            'postal_code' => 'sometimes|string|max:20',
            'country' => 'sometimes|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'employee_id' => 'sometimes|string|max:50|unique:adminstrators,employee_id,' . $this->route('admin'),
            'position' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'date_of_hire' => 'sometimes|date',
            'employment_type' => 'nullable|in:Full-Time,Part-Time,Contract',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_relationship' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'emergency_contact_email' => 'nullable|string|email|max:255',
            'user_id' => 'sometimes|exists:users,id',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'email.unique' => 'An administrator with this email already exists.',
            'phone_number.unique' => 'An administrator with this phone number already exists.',
            'employee_id.unique' => 'An administrator with this employee ID already exists.',
            'user_id.exists' => 'The selected user does not exist.',
            // Add more custom messages as needed
        ];
    }
}
