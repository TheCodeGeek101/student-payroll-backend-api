<?php


namespace App\Containers\UsersSection\Tutors\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Containers\SchoolsSection\Subjects\Resources\SubjectResource;
class TutorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'hire_date' => $this->hire_date,
            'department' => $this->department,
            'bio' => $this->bio,
            'subjects' => SubjectResource::collection($this->whenLoaded('subjects')),
        ];
    }
}
