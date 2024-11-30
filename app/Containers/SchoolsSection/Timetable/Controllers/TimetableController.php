<?php

namespace App\Containers\SchoolsSection\Timetable\Controllers;

use App\Containers\SchoolsSection\Class\Data\Models\ClassModel;
use App\Containers\SchoolsSection\Timetable\Requests\StoreTimetableRequest;
use App\Containers\SchoolsSection\Timetable\Data\Models\Timetable;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Containers\SchoolsSection\Timetable\Actions\CreateTimetableAction;
use App\Containers\SchoolsSection\Timetable\Actions\GetTeacherTimetableAction;
use App\Containers\SchoolsSection\Timetable\Resources\TimetableResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Controllers\Controller;
use App\Containers\UsersSection\Tutors\Data\Models\Tutor;
use App\Containers\SchoolsSection\Timetable\Actions\GetTimetableAction;

class TimetableController extends Controller
{
    public function index(ClassModel $class): JsonResponse
    {   
       $timetable = app(GetTimetableAction::class)->run($class);
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

    public function teacherTimetable(Tutor $tutor):JsonResponse
    {
        $timetable = app(GetTeacherTimetableAction::class)->run($tutor);
        return response()->json([
            'timetable'=>$timetable
        ],200);
    }
}
