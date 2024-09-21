<?php

namespace App\Containers\SchoolsSection\Events\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CalendarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            // 'term' => new TermResource($this->whenLoaded('terms')), // Load related term
            'start_date' => $this->start_date->toDateTimeString(),
            'end_date' => $this->end_date->toDateTimeString(),
            'description' => $this->description,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
