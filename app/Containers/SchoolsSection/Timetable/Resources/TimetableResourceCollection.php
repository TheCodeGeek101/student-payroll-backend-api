<?php

namespace App\Containers\SchoolsSection\Timetable\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TimetableResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
        'data' => $this->collection,
        'link' => [
            'self' => 'link-value',
        ]
    ];
    }
}
