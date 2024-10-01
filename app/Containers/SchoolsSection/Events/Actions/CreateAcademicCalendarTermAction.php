<?php

namespace App\Containers\SchoolsSection\Events\Actions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;
use App\Containers\SchoolsSection\Term\Requests\StoreTermRequest;
use App\Ship\Actions\Action;
use App\Containers\SchoolsSection\Term\Data\Models\Term;

class CreateAcademicCalendarTermAction extends Action
{
    public function run(StoreTermRequest $request)
    {
        $term = null;

        // Get the last created term to compare the dates
        $lastTerm = Term::orderBy('end_date', 'desc')->first();

        // Convert request start_date to Carbon instance
        $startDate = Carbon::parse($request->start_date);

        // Ensure end_date is present and convert to Carbon instance
        $endDate = Carbon::parse($request->end_date);

        // Validate the new term's start and end dates
        if ($lastTerm && $startDate->lte($lastTerm->end_date)) {
            // Custom error message for start date
            $errorMessage = 'The start date of the new term must be after the end date of the previous term (' . $lastTerm->end_date->format('Y-m-d') . '). Please provide a valid date range.';
            throw ValidationException::withMessages(['start_date' => [$errorMessage]]);
        }

        if ($startDate->gte($endDate)) {
            // Custom error message for invalid date range
            throw ValidationException::withMessages(['end_date' => ['The end date must be after the start date.']]);
        }

        // If validation passes, proceed with creating the new term
        DB::transaction(function () use ($request, &$term) {
            $term = Term::create($request->validated());
        });
        return $term;
    }
}