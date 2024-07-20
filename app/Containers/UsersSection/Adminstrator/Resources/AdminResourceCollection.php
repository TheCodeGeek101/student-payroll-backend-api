<?php

namespace App\Containers\UsersSection\Adminstrator\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AdminResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'object' => 'AdminstratorResourceCollection',
            'data' => $this->collection,
            'links' => [
                'self' => 'link-value'
            ]
        ];
    }
}
