<?php

namespace App\Containers\SchoolsSection\Term\Actions;
use App\Ship\Actions\Action;
use App\Containers\SchoolsSection\Term\Requests\StoreAcademicCalendarRequest;
use App\Containers\SchoolsSection\Term\Data\Models\AcademicCalendar;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateAcademicCalendarAction extends Action
{
    public function run(StoreAcademicCalendarRequest $request)
    {
          // Check if a term already exists within the specified dates
          $existingCalendar = AcademicCalendar::where(function ($query) use ($request) {
            $query->where('start_date', '<=', $request->end_date)
                  ->where('end_date', '>=', $request->start_date);
        })->first();

        // If a term exists, return a 409 Conflict response
        if ($existingCalendar) {
            throw new HttpResponseException(
                response()->json(['message' => 'A calendar already exists within the specified dates.'], 409)
            );
        }

        // Proceed with creating the new term
        $academicCalendar = null;
        DB::transaction(function () use ($request, &$academicCalendar) {
            $academicCalendar = AcademicCalendar::create($request->validated());
        });

        return $academicCalendar;

    }
}