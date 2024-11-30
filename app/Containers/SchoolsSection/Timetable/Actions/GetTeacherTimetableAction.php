<?php

namespace App\Containers\SchoolsSection\Timetable\Actions;
use App\Ship\Actions\Action;
use App\Containers\SchoolsSection\Timetable\Data\Models\Timetable;
use App\Containers\UsersSection\Tutors\Data\Models\Tutor;

class GetTeacherTimetableAction extends Action
{
    public function run(Tutor $tutor)
    {
        $timetable = Timetable::join('subjects','subjects.id','=','timetables.subject_id')
                              ->join('tutors','tutors.id','=','timetables.tutor_id')
                              ->join('classroom','classroom.id','=','timetables.class_id')
                              ->where('timetables.tutor_id','=',$tutor->id)
                              ->select(
                                'subjects.name as subject_name',
                                'timetables.*',
                                'tutors.first_name as tutor_first_name',
                                'tutors.last_name as tutor_last_name',
                                'classroom.name as class_name'
                              )
                              ->get();
         return $timetable;
    }
}