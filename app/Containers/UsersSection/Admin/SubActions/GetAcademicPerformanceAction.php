<?php

namespace App\Containers\UsersSection\Admin\SubActions;

use App\Containers\SchoolsSection\Grades\Data\Models\Grade;
use App\Containers\UsersSection\Tutors\Data\Models\Tutor;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;

class GetAcademicPerformanceAction
{
    private const TOP_STUDENTS_LIMIT = 10;
    private const STRUGGLING_STUDENTS_LIMIT = 10;

    public function run(): array
    {
        try {
            // Fetch necessary statistics for graphs
            $performanceGraph = $this->getPerformanceGraphData();
            $topPerformingGraph = $this->getTopPerformingGraphData();
            $strugglingStudentsGraph = $this->getStrugglingStudentsGraphData();
            $teacherPerformanceGraph = $this->getTeacherPerformanceGraphData();

            // Prepare the final response with only the statistics for graphs
            return [
                'status' => 'success',
                'performance_graph' => $performanceGraph,
                'top_performing_graph' => $topPerformingGraph,
                'struggling_students_graph' => $strugglingStudentsGraph,
                'teacher_performance_graph' => $teacherPerformanceGraph,
            ];

        } catch (\Exception $e) {
            // Log the exception
            Log::error('Error fetching academic performance: ' . $e->getMessage());

            // Return error response
            return [
                'status' => 'error',
                'message' => 'An error occurred while fetching academic performance: ' . $e->getMessage(),
            ];
        }
    }

    private function getPerformanceGraphData(): array
    {
        $grades = Grade::with('student', 'subject')->get();
        
        // Prepare data for the overall performance graph
        $graphData = [];
        $studentIds = $grades->pluck('student_id')->unique();

        foreach ($studentIds as $studentId) {
            // Get average grade for each student
            $studentGrades = $grades->where('student_id', $studentId);
            $averageScore = $studentGrades->avg('grade_value');
            $graphData[] = [
                'student_id' => $studentId,
                'average_score' => number_format($averageScore, 2),
            ];
        }

        // Prepare labels and data points
        $labels = $studentIds->map(function ($id) {
            return "Student $id"; // Label format for graph
        });

        $dataPoints = array_map(function ($item) {
            return (float) $item['average_score'];
        }, $graphData);

        return [
            'labels' => $labels,
            'dataPoints' => $dataPoints,
        ];
    }

    private function getTopPerformingGraphData(): array
    {
        // Get top-performing students and calculate their average scores
        $topPerformers = Grade::select('student_id')
            ->groupBy('student_id')
            ->orderByRaw('AVG(grade_value) DESC')
            ->limit(self::TOP_STUDENTS_LIMIT)
            ->get();

        // Prepare labels and data points
        $labels = $topPerformers->pluck('student_id')->map(function ($id) {
            return "Student $id";
        });

        $dataPoints = $topPerformers->map(function ($student) {
            $averageScore = Grade::where('student_id', $student->student_id)->avg('grade_value');
            return (float) number_format($averageScore, 2);
        });

        return [
            'labels' => $labels,
            'dataPoints' => $dataPoints->toArray(),
        ];
    }

    private function getStrugglingStudentsGraphData(): array
    {
        // Get struggling students and calculate their average scores
        $strugglingStudents = Grade::select('student_id')
            ->groupBy('student_id')
            ->orderByRaw('AVG(grade_value) ASC')
            ->limit(self::STRUGGLING_STUDENTS_LIMIT)
            ->get();

        // Prepare labels and data points
        $labels = $strugglingStudents->pluck('student_id')->map(function ($id) {
            return "Student $id";
        });

        $dataPoints = $strugglingStudents->map(function ($student) {
            $averageScore = Grade::where('student_id', $student->student_id)->avg('grade_value');
            return (float) number_format($averageScore, 2);
        });

        return [
            'labels' => $labels,
            'dataPoints' => $dataPoints->toArray(),
        ];
    }

    private function getTeacherPerformanceGraphData(): array
    {
        $teachers = Tutor::with('grades') // Ensure you have a relationship in the Tutor model to grades
            ->get()
            ->map(function ($teacher) {
                $totalGrades = $teacher->grades->count();
                $averageScore = $totalGrades > 0 ? $teacher->grades->sum('grade_value') / $totalGrades : 0;

                return [
                    'teacher_id' => $teacher->id,
                    'average_score' => number_format($averageScore, 2),
                ];
            });

        // Prepare labels and data points
        $labels = $teachers->pluck('teacher_id')->map(function ($id) {
            return "Teacher $id";
        });

        $dataPoints = $teachers->pluck('average_score')->map(function ($score) {
            return (float) $score;
        });

        return [
            'labels' => $labels,
            'dataPoints' => $dataPoints->toArray(),
        ];
    }
}
