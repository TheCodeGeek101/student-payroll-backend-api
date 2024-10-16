<?php

namespace App\Containers\SchoolsSection\Timetable\Controllers;

use App\Containers\SchoolsSection\Timetable\Requests\StoreTimetableRequest;
use App\Containers\SchoolsSection\Timetable\Data\Models\Timetable;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Containers\SchoolsSection\Timetable\Actions\CreateTimetableAction;
use App\Containers\SchoolsSection\Timetable\Resources\TimetableResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Controllers\Controller;

class TimetableController extends Controller
{
    public function index(): JsonResponse
    {   
        $timetable = Timetable::all();
        return response()->json([
            'timetables' => $timetable
        ],200);
    
    }

    public function store(StoreTimetableRequest $request):JsonResponse
    {
        $timetable = app(CreateTimetableAction::class)->run($request);
        return response()->json([
            'timetable' => $timetable
        ],201);
    }

    public function show(Timetable $timetable):JsonResource
    {
        return new TimetableResource($timetable);
    }
}
