<?php


namespace App\Containers\UsersSection\Admin\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
            'address' => [
                'street' => $this->street,
                'city' => $this->city,
                'state' => $this->state,
                'postal_code' => $this->postal_code,
                'country' => $this->country,
            ],
            'profile_picture_url' => $this->profile_picture_url, // Assuming this is a URL to the stored profile picture
            'employee_id' => $this->employee_id,
            'position' => $this->position,
            'department' => $this->department,
            'date_of_hire' => $this->date_of_hire,
            'employment_type' => $this->employment_type,
            'emergency_contact' => [
                'name' => $this->emergency_contact_name,
                'relationship' => $this->emergency_contact_relationship,
                'phone' => $this->emergency_contact_phone,
                'email' => $this->emergency_contact_email,
            ],
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
