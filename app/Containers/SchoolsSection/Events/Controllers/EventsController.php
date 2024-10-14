<?php

namespace App\Containers\SchoolsSection\Events\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Containers\SchoolsSection\Events\Actions\CreateSchoolCalendarAction;
use App\Containers\SchoolsSection\Events\Requests\StoreCalendarRequest;
use App\Containers\SchoolsSection\Term\Requests\StoreTermRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Containers\SchoolsSection\Events\Actions\CreateAcademicCalendarTermAction;
use App\Containers\SchoolsSection\Events\Requests\StoreEventRequest;
use App\Containers\SchoolsSection\Events\Actions\CreateEventAction;
use App\Containers\SchoolsSection\Events\Data\Models\Event;

class EventsController extends Controller
{
    public function index(): JsonResponse 
    {
        $events = Event::all();
        return response()->json([
            'events' => $events
        ],200);
    }

    public function createCalendar(StoreCalendarRequest $request): JsonResponse
    {
        $calendar = app(CreateSchoolCalendarAction::class)->run($request);
        return response()->json([
            'message' => 'Calendar created successfully',
            'calendar' => $calendar
        ], 200);
    }

    public function createTerm(StoreTermRequest $request): JsonResponse
    {
        $term = app(CreateAcademicCalendarTermAction::class)->run($request);
        return response()->json([
            'term' => $term,
            'message' => 'Term created successfully'
        ],201);
    }

    public function store(StoreEventRequest $request): JsonResponse
    {
        $event = app(CreateEventAction::class)->run($request);
        return  response()->json([
            'event' => $event,
            'message' => 'event created successfully'
        ],201);
    }
    
    
    public function destroy(Event $event): JsonResponse
    {
        $event->delete();
        return response()->json([
            'message' => 'event deleted successfully'
        ],200);
    }
}
