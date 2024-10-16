<?php

namespace App\Containers\SchoolsSection\Timetable\Actions;

use App\Ship\Actions\Action;
use Illuminate\Support\Facades\DB;
use App\Containers\SchoolsSection\Timetable\Requests\StoreTimetableRequest;
use App\Containers\SchoolsSection\Timetable\Data\Models\Timetable;
use App\Containers\UsersSection\Tutors\Data\Models\Tutor;
use Exception;

class CreateTimetableAction extends Action
{
    public function run(StoreTimetableRequest $request)
    {
        try {
            $tutor = Tutor::where('id', '=', $request->validated()['tutor_id'])->first();

            // Check for timetable conflicts for this tutor
            $conflictingTimetable = Timetable::where('tutor_id', $tutor->id)
                ->where('day_of_week', $request->validated()['day_of_week'])
                ->where(function($query) use ($request) {
                    $query->where('start_time', '<', $request->validated()['end_time'])
                          ->where('end_time', '>', $request->validated()['start_time']);
                })
                ->first();

            // If a conflict exists, return an error
            if ($conflictingTimetable) {
                return [
                    'error' => 'This tutor is already scheduled to teach another subject at the requested time.'
                ];
            }

            // No conflict, proceed to create the timetable entry
            $timetable = null;
            DB::transaction(function() use ($request, &$timetable) {
                $timetable = Timetable::create($request->validated());
            });

            return $timetable;

        } catch (Exception $e) {
            return [
                'error' => $e->getMessage()
            ];
        }
    }
}
