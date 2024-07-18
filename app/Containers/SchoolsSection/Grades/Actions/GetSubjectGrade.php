<?php

namespace App\Containers\SchoolsSection\Grades\Actions;

use App\Ship\Actions\Action;
use App\Containers\SchoolsSection\Grades\Data\Models\Grades;
use Illuminate\Support\Facades\DB;
class GetSubjectGrade extends Action
{
    public function run()
    {
        $grades = Grades::join('subjects', 'subjects.id', '=', 'grades.subject_id')->with('subject','initiator','student')->get('grades.*','subjects.*','student.*','tutor.*');
        return $grades;
    }

}
