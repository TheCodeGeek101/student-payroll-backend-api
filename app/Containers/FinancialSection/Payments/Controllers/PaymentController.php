<?php

namespace App\Containers\FinancialSection\Payments\Controllers;

use App\Http\Controllers\Controller;
use App\Containers\FinancialSection\Payments\Requests\PaymentRequest;
use App\Containers\FinancialSection\Payments\Actions\MakePaymentAction;
use App\Containers\UsersSection\Students\Data\Models\Student;
use App\Containers\FinancialSection\Payments\Data\Models\Payment;
use App\Containers\FinancialSection\Payments\Resources\PaymentResource;
use Illuminate\Http\JsonResponse;
use App\Containers\FinancialSection\Payments\Actions\RecentTransactions;
use App\Containers\FinancialSection\Payments\Actions\StoreTransactionsAction;
use App\Containers\FinancialSection\Payments\Requests\StoreTransactionRequest;

class PaymentController extends Controller
{
    public function index(Student $student): JsonResponse
    {
        $studentPayments = app(RecentTransactions::class)->run($student);
        return response()->json(
            [
                'message' => 'Student payments retrieved successfully',
                'payments' => $studentPayments
            ],
            200
        );
    }

    public function store(PaymentRequest $request): JsonResponse
    {
        // Pass the parameters in the correct order
        $payment = app(MakePaymentAction::class)->run($request);
        return response()->json([
            'record' => $payment,
            'message' => 'Payment record created successfully'
        ], 201);
    }
    public function show(Payment $payment): PaymentResource
    {
        return new PaymentResource($payment);
    }

    public function destroy(Payment $payment): JsonResponse
    {
        $payment->delete();
        return response()->json(['message' => 'Payment:' . $payment->tx_ref . 'made by' . $payment->studentName() . 'has been deleted successfully'], 200);
    }

    public function transactions(StoreTransactionRequest $request): JsonResponse
    {
        $transaction = app(StoreTransactionsAction::class)->run($request);
        return response()->json(
            [
                'message' => 'Transaction posted successfully',
                'data' => $transaction
            ],
            201
        );
    }
}
