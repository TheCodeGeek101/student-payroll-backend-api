<?php

namespace App\Containers\UsersSection\Admin\Controllers;

use App\Containers\FinancialSection\Payments\Data\Models\Payment;
use App\Containers\UsersSection\Students\Data\Models\Student;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Containers\UsersSection\Tutors\Data\Models\Tutor;
use App\Containers\SchoolsSection\Grades\Data\Models\Grade;
use Illuminate\Support\Facades\DB;
use App\Containers\UsersSection\Admin\SubActions\GetAcademicPerformanceAction;
use App\Containers\SchoolsSection\Class\Data\Models\ClassModel;


class AdminDashboardController extends Controller
{
    public function index()
    {

    }

    public function totalWithdrawnStudents(): JsonResponse
    {
        $students = Student::where('enrollment_status','=','withdrawn')->get()->count();
        return response()->json(['students'=>$students],200);
    }

    public function totalNumberOfTeachers(): JsonResponse
    {
        $teachers = Tutor::all()->count();
        return response()->json([
            'totalTeachers' => $teachers
        ],200);
    }
    

    public function classPerformance(): JsonResponse
    {
        $grades = Grade::join('subjects', 'subjects.id', '=', 'grades.subject_id')
                ->join('terms', 'terms.id', '=', 'grades.term_id')
                ->join('classroom', 'classroom.id', '=', 'grades.class_id') 
                ->join('students', 'students.id', '=', 'grades.student_id')    
                ->orderBy('grades.class_id')
                ->select(
                    'grades.grade_value as number_grade',
                    'grades.class_id'
                )
                ->get();

        foreach($grades as $grade)
        {   
            if($grade['number_grade'] >= 50)
            {
                return response()->json([
                    'grades' => $grade['number_grade']->count(),
                    'class' => $grade['class_id']
                ],200);
            }


            $gradeCount = $grades->count();

            return response()->json([
                'grades' => $grade['number_grade']->count(),
                'class' => $grade['class']
            ],200);

        }

    }

    public function totalNumberStudents(): JsonResponse
    {
        $students = Student::where('enrollment_status','=','active')->get()->count();
        return response()->json(['students'=>$students],200);
    }

    public function totalConfirmedAndPendingPayments(): JsonResponse
    {
        // Fetch all payments with student information
        $payments = Payment::join('students', 'students.id', '=', 'payments.student_id')
            ->join('classroom', 'classroom.id', '=', 'payments.class_id')
            ->join('terms', 'terms.id', '=', 'payments.term_id')
            ->where('payments.title', '=', 'School Fees')
            ->where('payments.confirmed', '=', true)
            ->select('students.id as student_id', 'payments.amount')
            ->get();

        // Define the required school fees
        $requiredFees = 20;

        // Initialize counters for full and pending payment students
        $fullPaymentsCount = 0;
        $pendingPaymentsCount = 0;

        // Group students based on their total payments
        $studentsPayments = $payments->groupBy('student_id');

        foreach ($studentsPayments as $studentId => $studentPayments) {
            // Sum the total amount paid by the student
            $totalPaid = $studentPayments->sum('amount');

            // Check if the student has made full payments or has pending payments
            if ($totalPaid >= $requiredFees) {
                $fullPaymentsCount++;
            } else {
                $pendingPaymentsCount++;
            }
        }

        // Return both counts in the response
        return response()->json([
            'full_payments_count' => $fullPaymentsCount,
            'pending_payments_count' => $pendingPaymentsCount
        ], 200);
    }

    public function monthlyPayments(): JsonResponse
    {
        // Fetch total fees collected grouped by month
        $monthlyCollections = Payment::select(
                DB::raw('DATE_FORMAT(payment_date, "%Y-%m") as month'),
                DB::raw('SUM(amount) as total_collected')
            )
            ->where('confirmed', true) // Ensure only confirmed payments are counted
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        return response()->json([
            'data' =>$monthlyCollections
        ],200);
    }


    public function academicPerformance(): JsonResponse
    {
        // Call the action to get academic performance data
        $performanceData = app(GetAcademicPerformanceAction::class)->run();

        // Return the performance data as a JSON response
        return response()->json([
            "performance" => $performanceData
        ],200);
    }

    public function totalStudentsPerClass(): JsonResponse
    {
        // Retrieve all classrooms
        $classrooms = ClassModel::all();
    
        // Check if there are no classrooms
        if ($classrooms->isEmpty()) {
            return response()->json([
                'error' => 'No classrooms found'
            ], 404);
        }
    
        // Initialize an array to hold the class names and student counts
        $classData = [];
    
        // Loop through each class and count the students
        foreach ($classrooms as $classroom) {
            $studentCount = Student::where('class_id', $classroom->id)->count();
            
            $classData[] = [
                'class_name' => $classroom->name,
                'total_students' => $studentCount
            ];
        }
    
        return response()->json([
            'classes' => $classData
        ], 200);
    }
    

}
