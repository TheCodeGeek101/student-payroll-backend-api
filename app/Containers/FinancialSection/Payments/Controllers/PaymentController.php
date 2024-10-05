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
use App\Containers\FinancialSection\Payments\Requests\StoreTransactionRequest;
use App\Containers\FinancialSection\Payments\Actions\ApprovePayment;
use App\Containers\UsersSection\Admin\Data\Models\Adminstrator;
use Illuminate\Http\Request;
use App\Containers\FinancialSection\Payments\Actions\StoreTransactionsAction;
use App\Containers\FinancialSection\Payments\Actions\RecentStudentTransactions;
use App\Containers\FinancialSection\Payments\Actions\ConfirmedTransactions;

class PaymentController extends Controller
{
    public function index(): JsonResponse
    {

        $studentPayments = app(RecentTransactions::class)->run();
        return response()->json(
            [
                'message' => 'Payments retrieved successfully',
                'payments' => $studentPayments
            ],
            200
        );
    }

    public function studentTransactions(Student $student): JsonResponse
    {
        $studentPayments = app(RecentStudentTransactions::class)->run($student);
    
        if ($studentPayments->isEmpty()) {
            return response()->json(
                [
                    'message' => 'This student hasn\'t made any payments yet.',
                    'payments' => []
                ],
                200
            );
        }
    
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

    // public function transactions(StoreTransactionRequest $request): JsonResponse
    // {
    //     $transaction = app(StoreTransactionsAction::class)->run($request);
    //     return response()->json(
    //         [
    //             'message' => 'Transaction posted successfully',
    //             'data' => $transaction
    //         ],
    //         201
    //     );
    // }
    public function approvePayment(Request $request, Adminstrator $admin): JsonResponse
    {
        app(ApprovePayment::class)->run($request, $admin);
        return response()->json([
            'message' => 'payment confirmed successfully',
        ], 200);
    }

    public function confirmedTransactions(): JsonResponse
    {
        $transactions = app(confirmedTransactions::class)->run();
        return response()->json([
            'message' => 'Transactions retrieved successfully',
            'payments' => $transactions
        ]);
    }
}
