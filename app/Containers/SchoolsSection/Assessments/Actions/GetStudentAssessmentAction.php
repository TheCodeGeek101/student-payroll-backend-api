<?php

namespace App\Containers\SchoolsSection\Assessments\Actions;

use App\Ship\Actions\Action;
use App\Containers\UsersSection\Students\Data\Models\Student;
use App\Containers\SchoolsSection\Assessments\Data\Models\Assessment;
use Illuminate\Http\Request;

class GetStudentAssessmentAction extends Action
{
    public function run(Request $request ,Student $student)
    {
            $data = $request->validate([
                'term_id' => 'required|exists:terms,id',
                'class_id' => 'required|exists:classroom,id'
            ]);

        $assessments = Assessment::join('students','assessments.student_id','students.id')
            ->join('subjects','assessments.subject_id','subjects.id')
            ->join('tutors','assessments.tutor_id','tutors.id')
            ->join('terms','terms.id','=','assessments.term_id')
            ->join('classroom','classroom.id','=','assessments.class_id')
            ->where('terms.id',$data['term_id'])
            ->where('classroom.id',$data['class_id'])
            ->where('students.id',$student->id)
            ->select(
                'assessments.score as assessment_score',
                'assessments.total_marks as assessment_marks',
                'assessments.comments as assessment_comments',
                'assessments.date as assessment_date',
                'assessments.id as assessment_id',
                'assessments.grade_value as assessment_grade_value',
                'subjects.name as subject_name',
                'subjects.id as subject_id',
                'subjects.code as subject_code',
                'subjects.description as subject_description',
                'subjects.credits as subject_credits',
                'tutors.first_name as tutor_name',
                'tutors.last_name as tutor_last_name',
                'students.first_name as student_name',
                'students.last_name as student_last_name',
                'terms.name as term_name',
                'classroom.name as class_name'
            )
            ->get();
        return $assessments;
    }
}
