<?php
namespace App\Containers\SchoolsSection\Class\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Containers\SchoolsSection\Subjects\Resources\SubjectResource;
use App\Containers\UsersSection\Tutors\Resources\TutorResource;
class ClassroomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'tutor' => new TutorResource($this->whenLoaded('tutor')),
            'schedule' => $this->schedule,
            'term' => $this->semester,
            'capacity' => $this->capacity,
            'enrolled_students_count' => $this->enrolled_students_count,
            'subject' => new SubjectResource($this->whenLoaded('subject')),
            'room' => $this->room,
            'status' => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
