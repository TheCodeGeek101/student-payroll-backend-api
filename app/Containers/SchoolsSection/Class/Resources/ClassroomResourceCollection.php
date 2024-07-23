<?php

namespace App\Containers\SchoolsSection\Class\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ClassroomResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'object'=> 'ClassroomResourceCollection',
            'data' => $this->collection,
            'links' => [
                'self' => 'link-value',
            ]
        ];
    }
}
