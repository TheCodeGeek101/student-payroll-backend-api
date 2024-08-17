<?php


namespace App\Containers\UsersSection\Admin\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminRequest extends FormRequest
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
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:adminstrators,email',
            'phone_number' => 'required|string|max:20|unique:adminstrators,phone_number',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:Male,Female,Other',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'employee_id' => 'required|string|max:50|unique:adminstrators,employee_id',
            'position' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'date_of_hire' => 'required|date',
            'employment_type' => 'nullable|in:Full-Time,Part-Time,Contract',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_relationship' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'emergency_contact_email' => 'nullable|string|email|max:255'
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'full_name.required' => 'The full name is required.',
            'full_name.string' => 'The full name must be a string.',
            'full_name.max' => 'The full name may not be greater than 255 characters.',

            'email.required' => 'The email address is required.',
            'email.string' => 'The email address must be a string.',
            'email.email' => 'The email address must be a valid email address.',
            'email.max' => 'The email address may not be greater than 255 characters.',
            'email.unique' => 'An administrator with this email already exists.',

            'phone_number.required' => 'The phone number is required.',
            'phone_number.string' => 'The phone number must be a string.',
            'phone_number.max' => 'The phone number may not be greater than 20 characters.',
            'phone_number.unique' => 'An administrator with this phone number already exists.',

            'date_of_birth.required' => 'The date of birth is required.',
            'date_of_birth.date' => 'The date of birth is not a valid date.',

            'gender.required' => 'The gender is required.',
            'gender.in' => 'The selected gender is invalid.',

            'street.required' => 'The street address is required.',
            'street.string' => 'The street address must be a string.',
            'street.max' => 'The street address may not be greater than 255 characters.',

            'city.required' => 'The city is required.',
            'city.string' => 'The city must be a string.',
            'city.max' => 'The city may not be greater than 255 characters.',

            'state.required' => 'The state is required.',
            'state.string' => 'The state must be a string.',
            'state.max' => 'The state may not be greater than 255 characters.',

            'postal_code.required' => 'The postal code is required.',
            'postal_code.string' => 'The postal code must be a string.',
            'postal_code.max' => 'The postal code may not be greater than 20 characters.',

            'country.required' => 'The country is required.',
            'country.string' => 'The country must be a string.',
            'country.max' => 'The country may not be greater than 255 characters.',

            'employee_id.required' => 'The employee ID is required.',
            'employee_id.string' => 'The employee ID must be a string.',
            'employee_id.max' => 'The employee ID may not be greater than 50 characters.',
            'employee_id.unique' => 'An administrator with this employee ID already exists.',

            'position.string' => 'The position must be a string.',
            'position.max' => 'The position may not be greater than 255 characters.',

            'department.string' => 'The department must be a string.',
            'department.max' => 'The department may not be greater than 255 characters.',

            'date_of_hire.required' => 'The date of hire is required.',
            'date_of_hire.date' => 'The date of hire is not a valid date.',

            'employment_type.in' => 'The selected employment type is invalid.',

            'emergency_contact_name.string' => 'The emergency contact name must be a string.',
            'emergency_contact_name.max' => 'The emergency contact name may not be greater than 255 characters.',

            'emergency_contact_relationship.string' => 'The emergency contact relationship must be a string.',
            'emergency_contact_relationship.max' => 'The emergency contact relationship may not be greater than 255 characters.',

            'emergency_contact_phone.string' => 'The emergency contact phone must be a string.',
            'emergency_contact_phone.max' => 'The emergency contact phone may not be greater than 20 characters.',

            'emergency_contact_email.string' => 'The emergency contact email must be a string.',
            'emergency_contact_email.email' => 'The emergency contact email must be a valid email address.',
            'emergency_contact_email.max' => 'The emergency contact email may not be greater than 255 characters.',


        ];
    }
}
