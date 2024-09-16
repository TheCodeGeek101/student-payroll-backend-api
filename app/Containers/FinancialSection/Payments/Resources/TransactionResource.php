<?php

namespace App\Containers\FinancialSection\Payments\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'event_type' => $this->event_type,
            'tx_ref' => $this->tx_ref,
            'mode' => $this->mode,
            'type' => $this->type,
            'status' => $this->status,
            'number_of_attempts' => $this->number_of_attempts,
            'reference' => $this->reference,
            'currency' => $this->currency,
            'amount' => $this->amount,
            'charges' => $this->charges,
            'customization' => [
                'title' => $this->customization_title,
                'description' => $this->customization_description,
                'logo' => $this->customization_logo,
            ],
            'meta' => [
                'uuid' => $this->meta_uuid,
                'response' => $this->meta_response,
            ],
            'authorization' => [
                'channel' => $this->authorization_channel,
                'card_number' => $this->authorization_card_number,
                'expiry' => $this->authorization_expiry,
                'brand' => $this->authorization_brand,
                'provider' => $this->authorization_provider,
                'mobile_number' => $this->authorization_mobile_number,
                'completed_at' => $this->authorization_completed_at,
            ],
            'customer' => [
                'email' => $this->customer_email,
                'first_name' => $this->customer_first_name,
                'last_name' => $this->customer_last_name,
            ],
            'logs' => $this->logs ? json_decode($this->logs, true) : [],
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
