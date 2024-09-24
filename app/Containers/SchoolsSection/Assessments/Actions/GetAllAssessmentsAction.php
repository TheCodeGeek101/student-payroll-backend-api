<?php 

namespace App\Containers\SchoolsSection\Assessments\Actions;

use App\Containers\SchoolsSection\Subjects\Data\Models\Subject;
use App\Containers\SchoolsSection\Term\Data\Models\Term;
use App\Ship\Actions\Action;
use App\Containers\SchoolsSection\Assessments\Data\Models\Assessment;

class GetAllAssessmentsAction extends Action
{
    public function run(Subject $subject, Term $term)
    {
        $assessments = Assessment::join('subjects','subjects.id','=','assessments.subject_id')
            ->join('students','students.id','=','assessments.student_id')
            ->join('tutors','tutors.id','=','assessments.tutor_id')
            ->join('terms','assessments.term_id','=','terms.id')
            ->where('subjects.id',$subject->id)
            ->where('terms.id',$term->id)
            ->select(
                'assessments.id as assessment_id',
                'assessments.score as assessment_score',
                'assessments.total_marks as assessment_marks',
                'assessments.grade_value as assessment_grade_value',
                'assessments.comments as assessment_comments',
                'assessments.date as assessment_date',
                'students.first_name as student_first_name',
                'students.last_name as student_last_name',
                'subjects.name as subject_name',
                'subjects.code as subject_code',
                'tutors.first_name as tutor_first_name',
                'tutors.last_name as tutor_last_name',
                'terms.name as term_name',
            )->get();
            return $assessments;
    }
}