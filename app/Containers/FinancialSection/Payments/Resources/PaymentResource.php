<?php

namespace App\Containers\FinancialSection\Payments\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'student' => [
                'id' => $this->student->id,
                'name' => $this->student->name,  // Assuming 'name' exists in Student model
            ],
            'class_id' => $this->class_id,
            'term_id' => $this->term_id,
            'amount' => $this->amount,
            'description' => $this->description,
            'payment_date' => $this->payment_date,
            'confirmed' => $this->confirmed,
            'tx_ref' => $this->tx_ref,
            'currency' => $this->currency,
            'title' => $this->title,
            'confirmed_by' => $this->confirmed_by ? [
                'id' => $this->confirmedBy->id,
                'name' => $this->confirmedBy->name,  // Assuming 'name' exists in Administrator model
            ] : null,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
