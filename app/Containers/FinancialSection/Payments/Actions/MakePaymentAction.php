<?php

namespace App\Containers\FinancialSection\Payments\Actions;

use App\Ship\Actions\Action;
use App\Containers\FinancialSection\Payments\Requests\PaymentRequest;
use App\Containers\UsersSection\Students\Data\Models\Student;

class MakePaymentAction extends Action
{
    public function run(PaymentRequest $request, Student $student)
    {
        $makePayment = $student->payments()->create(array_merge($request->validated(), ['received_by' => 1]));
        return $makePayment;
    }
}

