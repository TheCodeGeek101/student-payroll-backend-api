<?php

namespace App\Containers\UsersSection\Students\Actions;

use App\Ship\Actions\Action;
use App\Containers\FinancialSection\Payments\Data\Models\Payment;
use App\Containers\SchoolsSection\Class\Data\Models\ClassModel;
use App\Containers\UsersSection\Students\Data\Models\Student;
use App\Containers\SchoolsSection\Term\Data\Models\Term;
use Illuminate\Http\Request;

class CanStudentRegisterAction extends Action
{
    public function run(Request $request, Student $student)
    {
        $data = $request->validate([
            'term_id' => 'required|exists:terms,id',
            'class_id' => 'required|exists:classroom,id'
        ]);

        // $termId = ClassModel::where('classroom.id','=' $data['term_id'])->get();
        // Fetch all payments made by the student for the specified term and class
        $payments = Payment::join('students', 'students.id', '=', 'payments.student_id')
            ->join('classroom', 'classroom.id', '=', 'payments.class_id')
            ->join('terms', 'terms.id', '=', 'payments.term_id')
            ->where('students.id', '=', $student->id)
            ->where('classroom.id', '=', $data['class_id'])
            ->where('terms.id', '=', $data['term_id'])
            ->where('payments.title','=','School Fees')
            ->where('payments.confirmed','=',true)
            ->select('payments.amount')
            ->get();

        // Calculate the total payments made
        $totalPayments = $payments->sum('amount');

        // Define the required school fees
        $requiredFees = 20;

        // Check if the total payments meet or exceed the required fees
        if ($totalPayments >= $requiredFees) {
            return true; // Student can register
        } else {
            // Calculate the amount needed to reach the required fees
            $amountNeeded = $requiredFees - $totalPayments;
            return [
                'can_register' => false,
                'amount_needed' => $amountNeeded,
            ]; // Return the needed amount
        }
    }
}
