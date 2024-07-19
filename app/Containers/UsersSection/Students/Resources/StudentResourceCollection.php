<?php

namespace App\Containers\UsersSection\Students\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class StudentResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'object' => 'StudentResourceCollection',
            'data' => $this->collection,
            'links' => [
                'self' => 'link-value',
            ]
        ];
    }
}
