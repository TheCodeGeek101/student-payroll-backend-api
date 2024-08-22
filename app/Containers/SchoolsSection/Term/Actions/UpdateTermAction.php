<?php

namespace App\Containers\SchoolsSection\Term\Actions;
use App\Containers\SchoolsSection\Term\Data\Models\Term;
use App\Containers\SchoolsSection\Term\Requests\UpdateTermRequest;
use App\Containers\SchoolsSection\Term\Terms;
use App\Ship\Actions\Action;

class UpdateTermAction extends Action
{

    public function run(UpdateTermRequest $request, Term $term): Term
    {
        $updatedTerm = $term->update($request->validated());
        return $updatedTerm;
    }

}
