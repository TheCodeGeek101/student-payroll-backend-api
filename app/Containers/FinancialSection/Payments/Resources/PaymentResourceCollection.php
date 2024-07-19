<?php

namespace App\Containers\FinancialSection\Payments\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PaymentResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'object' => 'PaymentResourceCollection',
            'data' => $this->collection,
            'links' => [
                'self' => 'link-value',
            ]
        ];
    }
}
