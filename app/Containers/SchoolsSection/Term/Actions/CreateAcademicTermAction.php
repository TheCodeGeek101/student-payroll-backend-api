<?php

namespace App\Containers\SchoolsSection\Term\Actions;

use Illuminate\Support\Facades\DB;
use App\Containers\SchoolsSection\Term\Data\Models\Term;
use App\Containers\SchoolsSection\Term\Requests\StoreTermRequest;
use App\Ship\Actions\Action;

class CreateAcademicTermAction extends Action
{
    public function run(StoreTermRequest $request)
    {
        // Proceed with creating the new term
        $term = null;
        DB::transaction(function () use ($request, &$term) {
            $term = Term::create($request->validated());
        });

        return $term;
    }
}
