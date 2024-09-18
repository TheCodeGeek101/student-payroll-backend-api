<?php

namespace App\Containers\FinancialSection\Payments\Actions;

use App\Containers\FinancialSection\Payments\Data\Models\Payment;
use App\Ship\Actions\Action;
use Illuminate\Support\Facades\DB;
use App\Containers\UsersSection\Admin\Data\Models\Adminstrator;
use Illuminate\Http\Request;

class ApprovePayment extends Action
{
    public function run(Request $request, Adminstrator $admin)
    {
        $data = $request->validate([
            'tx_ref' => 'required|exists:payments,tx_ref'
        ]);

        try {
            $payment = null;
            DB::transaction(function () use (&$payment, &$admin, &$data) {
                $payment = Payment::where('tx_ref', '=', $data['tx_ref'])->update([
                    'confirmed' => true,
                    'confirmed_by' => $admin->id,
                ]);
            });
        } catch (\Exception $exception) {
            return redirect()->back()->with('failed', $exception);
        }

        return $payment;
    }
}
