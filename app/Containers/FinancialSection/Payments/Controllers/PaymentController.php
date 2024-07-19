<?php

namespace App\Containers\FinancialSection\Payments\Controllers;

use App\Http\Controllers\Controller;
use App\Containers\FinancialSection\Payments\Requests\PaymentRequest;
use App\Containers\FinancialSection\Payments\Actions\MakePaymentAction;
use App\Containers\UsersSection\Students\Data\Models\Student;
use App\Containers\FinancialSection\Payments\Data\Models\Payment;

class PaymentController extends Controller
{
    public function index(){
        $payments = Payment::all();
        return response()->json(['message'=>'Payments retrieved successfully', 'payments' => $payments]);
    }
    public function payments(PaymentRequest $request, Student $student)
    {
        // Pass the parameters in the correct order
        app(MakePaymentAction::class)->run($request, $student);
        return response()->json(['message' => 'Payment posted successfully'], 200);
    }
}
