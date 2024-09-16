<?php

namespace App\Containers\FinancialSection\Payments\Actions;

use App\Ship\Actions\Action;
use App\Containers\FinancialSection\Payments\Requests\PaymentRequest;
use App\Containers\UsersSection\Students\Data\Models\Student;
use Illuminate\Support\Facades\Log;
use App\Containers\FinancialSection\Payments\Data\Models\Payment;
use Exception;
use Illuminate\Support\Facades\DB;

class MakePaymentAction extends Action
{
    public function run(PaymentRequest $request)
    {

        $payments = null;
        DB::transaction(function () use ($request, &$payments) {
            $payments = Payment::create($request->validated());
        });
        return $payments;
    }
}
