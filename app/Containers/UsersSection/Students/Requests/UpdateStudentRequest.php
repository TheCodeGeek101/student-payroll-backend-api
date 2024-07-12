<?php

namespace App\Containers\UsersSection\Students\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'in:F,M'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'phone_number' => ['required', 'regex:/^[\+0-9\-\(\)\s]*$/'],
            'email' => ['required', 'email', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'postal_address' => ['required', 'string', 'max:255'],
            'guardian_name' => ['required', 'string', 'max:255'],
            'guardian_contact' => ['required', 'regex:/^[\+0-9\-\(\)\s]*$/'],
            'admission_date' => ['required', 'date'],
            'emergency_contact' => ['required', 'regex:/^[\+0-9\-\(\)\s]*$/'],
            'previous_school' => ['required', 'string', 'max:255'],
            'medical_info' => ['required', 'string', 'max:500'],
        ];
    }


    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required',
            'last_name.required' => 'Last name is required',
            'gender.required' => 'Gender is required',
            'date_of_birth.required' => 'Date of birth is required',
            'date_of_birth.before' => 'Date of birth must be before today',
            'phone_number.required' => 'Phone number is required',
            'phone_number.regex' => 'Phone number format is invalid',
            'email.required' => 'Email is required',
            'email.email' => 'Email format is invalid',
            'address.required' => 'Address is required',
            'postal_address.required' => 'Postal address is required',
            'guardian_name.required' => 'Guardian name is required',
            'guardian_contact.required' => 'Guardian contact is required',
            'guardian_contact.regex' => 'Guardian contact format is invalid',
            'admission_date.required' => 'Admission date is required',
            'emergency_contact.required' => 'Emergency contact is required',
            'emergency_contact.regex' => 'Emergency contact format is invalid',
            'previous_school.required' => 'Previous school is required',
            'medical_info.required' => 'Medical information is required',
        ];
    }
}
