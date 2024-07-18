<?php

// app/Containers/UsersSection/Tutors/Requests/StoreTutorRequest.php

namespace App\Containers\UsersSection\Tutors\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreTutorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Adjust authorization logic as needed
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors()
        ], 422));
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'hire_date' => 'required|date',
            'department' => 'nullable|string|max:255',
            'subjects.*' => 'exists:subjects,id',
            'bio' => 'nullable|string',
        ];
    }
}
