<?php

namespace App\Containers\SchoolsSection\Term\Actions;

use Illuminate\Support\Facades\DB;
use App\Containers\SchoolsSection\Term\Data\Models\Term;
use App\Containers\SchoolsSection\Term\Requests\StoreTermRequest;
use App\Ship\Actions\Action;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateAcademicTermAction extends Action
{
    public function run(StoreTermRequest $request)
    {
        // Check if a term already exists within the specified dates
        $existingTerm = Term::where(function ($query) use ($request) {
            $query->where('start_date', '<=', $request->end_date)
                  ->where('end_date', '>=', $request->start_date);
        })->first();

        // If a term exists, return a 409 Conflict response
        if ($existingTerm) {
            throw new HttpResponseException(
                response()->json(['message' => 'A term already exists within the specified dates.'], 409)
            );
        }

        // Proceed with creating the new term
        $term = null;
        DB::transaction(function () use ($request, &$term) {
            $term = Term::create($request->validated());
        });

        return $term;
    }
}
