<?php

namespace App\Containers\FinancialSection\Payments\Actions;

use App\Ship\Actions\Action;
use App\Containers\FinancialSection\Payments\Data\Models\Payment;

class ConfirmedTransactions extends Action
{
    public function run()
    {
        $confirmedPayments = Payment::join('students', 'students.id', '=', 'payments.student_id')
            ->join('terms', 'terms.id', '=', 'payments.term_id')
            ->join('classroom', 'classroom.id', '=', 'payments.class_id')
            ->where('payments.confirmed', '=', true)
            ->select(
                'payments.title',
                'payments.description',
                'payments.tx_ref',
                'payments.amount',
                'payments.currency',
                'payments.confirmed',
                'students.first_name as student_first_name',
                'students.last_name as student_last_name',
                'classroom.name as class_name',
                'terms.name as term_name'
            )
            ->get();
        return $confirmedPayments;
    }
}
