<?php

namespace App\Containers\SchoolsSection\Grades\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GradesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'tutor_id' => $this->tutor_id,
            'student_id' => $this->student_id,
            'subject_id' => $this->subject_id,
            'grade' => $this->grade,
            'comments' => $this->comments,
            'graded_at' => $this->graded_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
