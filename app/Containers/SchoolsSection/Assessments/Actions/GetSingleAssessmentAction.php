<?php

namespace App\Containers\SchoolsSection\Assessments\Actions;

use App\Containers\SchoolsSection\Assessments\Data\Models\Assessment;
use App\Ship\Actions\Action;

class GetSingleAssessmentAction extends Action
{
    public function run(Assessment $assessment)
    {
        $singleAssessment = Assessment::join('students','assessments.student_id','students.id')
        ->join('subjects','assessments.subject_id','subjects.id')
        ->join('tutors','assessments.tutor_id','tutors.id')
        ->join('terms','assessments.term_id','=','terms.id')
        ->where('assessments.id',$assessment->id)
        ->select(
            'assessments.*',
            'subjects.name as subject_name',
            'subjects.code as subject_code',
            'students.first_name as student_first_name',
            'students.last_name as student_last_name',
            'tutors.first_name as tutor_first_name',
            'tutors.last_name as tutor_last_name',
            'terms.name as term_name'
        )
        ->get();
       return $singleAssessment;
    }
}