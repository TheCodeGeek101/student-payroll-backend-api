<?php

namespace App\Containers\UsersSection\Students\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'student_id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'gender' => $this->gender,
            'date_of_birth' => $this->date_of_birth,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'address' => $this->address,
            'postal_address' => $this->postal_address,
            'guardian_name' => $this->guardian_name,
            'guardian_contact' => $this->guardian_contact,
            'admission_date' => $this->admission_date,
            'emergency_contact' => $this->emergency_contact,
            'previous_school' => $this->previous_school,
            'medical_info' => $this->medical_info,
        ];
    }
}
