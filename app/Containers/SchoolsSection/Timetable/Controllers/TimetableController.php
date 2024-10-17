<?php

namespace App\Containers\SchoolsSection\Timetable\Controllers;

use App\Containers\SchoolsSection\Class\Data\Models\ClassModel;
use App\Containers\SchoolsSection\Timetable\Requests\StoreTimetableRequest;
use App\Containers\SchoolsSection\Timetable\Data\Models\Timetable;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Containers\SchoolsSection\Timetable\Actions\CreateTimetableAction;
use App\Containers\SchoolsSection\Timetable\Resources\TimetableResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Controllers\Controller;

class TimetableController extends Controller
{
    public function index(ClassModel $class): JsonResponse
    {   
        $timetable = Timetable::join('subjects','subjects.id','=','timetables.subject_id')
                              ->join('tutors','tutors.id','=','timetables.tutor_id')
                              ->join('classroom','classroom.id','=','timetables.class_id')
                              ->where('timetables.class_id','=',$class->id)
                              ->select(
                                'subjects.name as subject_name',
                                'timetables.*',
                                'tutors.first_name as tutor_first_name',
                                'tutors.last_name as tutor_last_name',
                                'classroom.name as class_name'
                              )
                              ->get();
        return response()->json([
            'timetables' => $timetable
        ],200);
    
    }

    public function store(ClassModel $class): JsonResponse
    {
        // Pass the validated request to the CreateTimetableAction
        $timetable = app(CreateTimetableAction::class)->run($class);
        
        return response()->json([
            'timetable' => $timetable
        ], 201);
    }

    public function show(Timetable $timetable):JsonResource
    {
        return new TimetableResource($timetable);
    }
}
