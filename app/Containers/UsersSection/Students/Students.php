<?php

namespace App\Containers\UsersSection\Students;
use App\Containers\UsersSection\Students\Resources\StudentResourceCollection;
use App\Containers\UsersSection\Students\Resources\StudentResource;
use App\Containers\UsersSection\Students\Data\Models\Student;
class Students
{
    public function resource(Student $student):StudentResource
    {
        return new StudentResource($student);
    }

    public function resourceCollection($students):StudentResourceCollection
    {
        return new StudentResourceCollection($students);
    }

}
