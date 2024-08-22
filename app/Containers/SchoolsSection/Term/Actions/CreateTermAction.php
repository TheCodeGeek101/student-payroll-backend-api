<?php

namespace App\Containers\SchoolsSection\Term\Actions;

use App\Ship\Actions\Action;
use App\Containers\SchoolsSection\Term\Requests\StoreTermRequest;
use App\Containers\SchoolsSection\Term\Data\Models\Term;
use Illuminate\Support\Facades\DB;

class CreateTermAction extends Action
{
    public function run(StoreTermRequest $request)
    {
        $term = null;

        DB::transaction(function () use ($request, &$term) {
            $term = Term::create($request->validated());
        });
        return $term;
    }
}
