<?php

namespace App\Containers\SchoolsSection\Term\Actions;

use App\Ship\Actions\Action;
use Illuminate\Support\Facades\DB;
use App\Containers\SchoolsSection\Term\Data\Models\AcademicCalendar;
use Carbon\Carbon;

class GetActiveTerm extends Action 
{
    public function run()
    {
        $today = Carbon::today();

        // Use a transaction to ensure the integrity of updates
        return DB::transaction(function() use ($today) {
            // Retrieve the academic term that contains today's date
            $activeTerm = AcademicCalendar::join('terms', 'terms.id', '=', 'academic_calendars.term_id')
                ->where('academic_calendars.start_date', '<=', $today)
                ->where('academic_calendars.end_date', '>=', $today)
                ->select(
                    'academic_calendars.*',
                    'terms.name as term_name'
                )
                ->first(); // Get the first (and ideally only) active term

            if ($activeTerm) {
                // If an active term is found, set it as active and deactivate others
                AcademicCalendar::where('id', '!=', $activeTerm->id)
                    ->where('is_active', true)
                    ->update(['is_active' => false]);

                AcademicCalendar::where('id', $activeTerm->id)
                    ->where('is_active', false)
                    ->update(['is_active' => true]);
            }

            return $activeTerm;
        });
    }
}
