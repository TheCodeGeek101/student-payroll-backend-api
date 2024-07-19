<?php

namespace App\Containers\FinancialSection\Payments;
use App\Containers\FinancialSection\Payments\Data\Models\Payment;
use App\Containers\FinancialSection\Payments\Resources\PaymentResource;
use App\Containers\FinancialSection\Payments\Resources\PaymentResourceCollection;

class Payments
{
    public function resource(Payment $payment): PaymentResource
    {
        return new PaymentResource($payment);
    }
    public function resourceCollection($payments): PaymentResourceCollection
    {
        return new PaymentResourceCollection($payments);
    }
}
