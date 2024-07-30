<?php

namespace App\Containers\SchoolsSection\Department\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DepartmentResourceCollection extends ResourceCollection
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
            'object'=> 'DepartmentResourceCollection',
            'links' => [
                'self' => 'link-value',
            ]
        ];
    }
}
