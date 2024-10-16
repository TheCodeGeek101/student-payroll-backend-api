<?php

namespace App\Containers\SchoolsSection\Term\Controllers;

use Illuminate\Http\Request;
use App\Containers\SchoolsSection\Term\Requests\StoreAcademicCalendarRequest;
use App\Containers\SchoolsSection\Term\Data\Models\AcademicCalendar;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Containers\SchoolsSection\Term\Actions\CreateAcademicCalendarAction;
use App\Http\Controllers\Controller;
use App\Containers\SchoolsSection\Term\Actions\GetActiveTerm;

class AcademicCalendarController extends Controller
{
    public function index(): JsonResponse
    { 
        $calendars = AcademicCalendar::all();
        return response()->json([
            'calendars' => $calendars
        ]);
    }

    public function store(StoreAcademicCalendarRequest $request): JsonResponse
    {
        $calendar = app(CreateAcademicCalendarAction::class)->run($request);
        return response()->json([
            'calendar' => $calendar,
            'message' => 'calendar created successfully'
        ],201);
    }

    public function show(AcademicCalendar $calendar): JsonResponse
    {
        return response()->json($calendar,200);
    }

    public function activeTerm(): JsonResponse
    {
        $activeTerm = app(GetActiveTerm::class)->run();
        return response()->json([
            'term' => $activeTerm
        ],200);
    }

}
