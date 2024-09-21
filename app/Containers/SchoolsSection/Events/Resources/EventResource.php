<?php

namespace App\Containers\SchoolsSection\Events\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'event_name' => $this->event_name,
            'description' => $this->description,
            'location' => $this->location,
            'start_date' => $this->start_date->toDateTimeString(),
            'end_date' => $this->end_date->toDateTimeString(),
            'is_recurring' => $this->is_recurring,
            'recurrence_pattern' => $this->recurrence_pattern,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
