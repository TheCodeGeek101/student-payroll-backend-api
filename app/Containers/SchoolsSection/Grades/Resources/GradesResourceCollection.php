<?php

namespace App\Containers\SchoolsSection\Grades\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GradesResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'object' => 'GradesResourceCollection',
            'data' => $this->collection,
            'links' => [
                'self' => 'link-value',
            ]
        ];
    }
}
