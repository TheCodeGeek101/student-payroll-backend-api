<?php

namespace App\Containers\UsersSection\Tutors\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TutorResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'object' => 'TutorResourceCollection',
            'data' => $this->collection,
            'links' => [
                'self' => 'link-value',
            ]
        ];
    }
}
