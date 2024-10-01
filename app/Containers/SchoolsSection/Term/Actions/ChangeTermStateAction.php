<?php

namespace App\Containers\SchoolsSection\Term\Actions;

use App\Containers\SchoolsSection\Term\Data\Models\Term;
use App\Ship\Actions\Action;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ChangeTermStateAction extends Action
{
    public function run()
    {
        $date = Carbon::today(); // Use today() for the date without time
        try {
            $termUpdated = null; // Changed variable name for clarity
            DB::transaction(function () use (&$termUpdated, $date) {
                $termUpdated = Term::where('start_date', '=', $date)
                    ->where('is_active', '=', false)
                    ->update(['is_active' => true]);
            });
            return $termUpdated; // Return the number of updated terms
        } catch (\Exception $exception) {
            // Handle the exception, returning an appropriate response
            return redirect()->back()->with('failed', $exception->getMessage());
        }
    }
}
