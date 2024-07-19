<?php

namespace App\Containers\UsersSection\Tutors;
use App\Containers\UsersSection\Tutors\Resources\TutorResource;
use App\Containers\UsersSection\Tutors\Tutor;
use App\Containers\UsersSection\Tutors\Resources\TutorResourceCollection;
class Tutors
{
    public function resource(Tutor $tutor): TutorResource
    {
        return new TutorResource($tutor);
    }

    public function resourceCollection($tutors): TutorResourceCollection
    {
        return new TutorResourceCollection($tutors);
    }
}
