<?php
namespace App\Containers\SchoolsSection\Department\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Containers\UsersSection\Tutors\Resources\TutorResource;
use App\Containers\SchoolsSection\Subjects\Resources\SubjectResource;

class DepartmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    // DepartmentResource.php
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'head_of_department' => optional($this->headOfDepartment)->name, // Use optional() to handle null
            'description' => $this->description,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            // Assuming a SubjectResource exists
        ];
    }

}
