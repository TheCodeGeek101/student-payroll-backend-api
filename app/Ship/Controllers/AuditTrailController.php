<?php

namespace App\Ship\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Containers\FinancialSection\Payments\Data\Models\Payment;
use Illuminate\Http\JsonResponse;
use App\Containers\SchoolsSection\Assessments\Data\Models\Assessment;
use App\Containers\SchoolsSection\Grades\Data\Models\Grade;

class AuditTrailController extends Controller
{
    public function paymentAudits(): JsonResponse
    {
        // Get the first confirmed Payment record with related data
        $payment = Payment::with(['student', 'term', 'studentClass'])
            ->where('confirmed', true)
            ->first();
    
        // Check if payment exists
        if (!$payment) {
            return response()->json([
                'message' => 'No payment found.'
            ], 404);
        }
    
        // Get all associated Audits
        $audits = $payment->audits;
    
        // Check if audits exist
        if ($audits->isEmpty()) {
            return response()->json([
                'message' => 'No audits found for this payment.'
            ], 404);
        }
    
        // Prepare payment details along with student, term, and class info
        $paymentDetails = [
            'title' => $payment->title,
            'description' => $payment->description,
            'tx_ref' => $payment->tx_ref,
            'amount' => $payment->amount,
            'currency' => $payment->currency,
            'confirmed' => $payment->confirmed,
            'student_first_name' => $payment->student->first_name,
            'student_last_name' => $payment->student->last_name,
            'class_name' => $payment->studentClass->name,
            'term_name' => $payment->term->name,
            'audits' => $audits,
        ];
    
        return response()->json($paymentDetails, 200);
    }
    


    public function gradeAudits(Grade $grade): JsonResponse
    {
        // Get the Grade model by ID
        $grade = Grade::findOrFail($grade);

        // Get all associated audits for the Grade
        $audits = $grade->audits;

        // Return the audits as a JSON response
        return response()->json([
            'audits' => $audits
        ], 200);
    }

    /**
     * Get audits for a specific Assessment model.
     *
     * @param int $assessmentId
     * @return JsonResponse
     */
    public function assessmentAudits(Assessment $assessment): JsonResponse
    {
        // Get the Assessment model by ID
        $assessment = Assessment::findOrFail($assessment);

        // Get all associated audits for the Assessment
        $audits = $assessment->audits;

        // Return the audits as a JSON response
        return response()->json([
            'audits' => $audits
        ], 200);
    }
}
