<?php

namespace App\Containers\SchoolsSection\Term;
use App\Containers\SchoolsSection\Term\Resources\TermResource;
use App\Containers\SchoolsSection\Term\Resources\TermResourceCollection;
use App\Containers\SchoolsSection\Term\Data\Models\Term;
class Terms
{
    public function resource(Term $term):TermResource
    {
        return new TermResource($term);
    }
    public function resourceCollection($terms):TermResourceCollection
    {
        return new TermResourceCollection($terms);
    }
}
