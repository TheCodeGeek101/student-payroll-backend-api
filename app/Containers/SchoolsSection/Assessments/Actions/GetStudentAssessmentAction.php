<?php

namespace App\Containers\SchoolsSection\Assessments\Actions;

use App\Ship\Actions\Action;
use App\Containers\UsersSection\Students\Data\Models\Student;
use App\Containers\SchoolsSection\Assessments\Data\Models\Assessment;
class GetStudentAssessmentAction extends Action
{
    public function run(Student $student)
    {
        $assessments = Assessment::join('students','assessments.student_id','students.id')
            ->join('subjects','assessments.subject_id','subjects.id')
            ->join('tutors','assessments.tutor_id','tutors.id')
            ->where('students.id',$student->id)
            ->select(
                'assessments.score as assessment_score',
                'assessments.total_marks as assessment_marks',
                'assessments.comments as assessment_comments',
                'assessments.date as assessment_date',
                'assessments.id as assessment_id',
                'assessments.grade_value as assessment_grade_value',
                'subjects.name as subject_name',
                'tutors.first_name as tutor_name',
                'tutors.last_name as tutor_last_name',
                'students.first_name as student_name',
                'students.last_name as student_last_name'
            )
            ->get();
        return $assessments;
    }

}
