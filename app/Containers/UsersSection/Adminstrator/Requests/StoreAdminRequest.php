<?php

namespace App\Containers\UsersSection\Adminstrator\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:administrators,email',
            'phone_number' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:Male,Female,Other',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'country' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'employee_id' => 'required|string|max:255|unique:administrators,employee_id',
            'position' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'date_of_hire' => 'required|date',
            'employment_type' => 'nullable|in:Full-Time,Part-Time,Contract',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_relationship' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'emergency_contact_email' => 'nullable|string|email|max:255',
        ];
    }

    /**
     * Get the custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'full_name.required' => 'The full name is required.',
            'email.required' => 'The email address is required.',
            'phone_number.required' => 'The phone number is required.',
            'date_of_birth.required' => 'The date of birth is required.',
            'gender.required' => 'The gender is required.',
            'street.required' => 'The street address is required.',
            'city.required' => 'The city is required.',
            'state.required' => 'The state is required.',
            'postal_code.required' => 'The postal code is required.',
            'country.required' => 'The country is required.',
            'profile_picture.image' => 'The profile picture must be an image.',
            'profile_picture.mimes' => 'The profile picture must be a file of type: jpeg, png, jpg, gif, svg.',
            'profile_picture.max' => 'The profile picture may not be greater than 2048 kilobytes.',
            'employee_id.required' => 'The employee ID is required.',
            'employee_id.unique' => 'The employee ID has already been taken.',
            'date_of_hire.required' => 'The date of hire is required.',
        ];
    }
}
