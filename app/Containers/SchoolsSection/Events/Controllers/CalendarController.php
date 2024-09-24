<?php

namespace App\Containers\SchoolsSection\Events\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Containers\SchoolsSection\Events\Requests\StoreCalendarRequest;
use App\Containers\SchoolsSection\Events\Actions\CreateCalendarAction;
use App\Containers\SchoolsSection\Events\Data\Models\Calendar;
use App\Containers\SchoolsSection\Events\Resources\CalendarResource;
use Illuminate\Http\JsonResponse;

class CalendarController extends Controller
{
    public function index():JsonResponse
    {
        $calendars = Calendar::all();
        return response()->json([
            'calendars' => $calendars
        ]);
    }

    public function store(StoreCalendarRequest $request):JsonResponse
    {
        $calendar = app(CreateCalendarAction::class)->run($request);
        return response()->json([
            'message'=> 'calendar stored successfully',
            'calendar' => $calendar
        ],201);        
    }

    public function show(Calendar $calendar)
    {
        return new CalendarResource($calendar);
    }

    public function delete(Calendar $calendar):JsonResponse
    {
        $calendar->delete();
        return response()->json([
            'message'=>'calendar deleted successfully'
        ],200);
    }
}

