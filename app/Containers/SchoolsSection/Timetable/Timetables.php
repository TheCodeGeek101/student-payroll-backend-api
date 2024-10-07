<?php

namespace App\Containers\SchoolsSection\Timetable;

use App\Containers\SchoolsSection\Timetable\Data\Models\Timetable;
use App\Containers\SchoolsSection\Timetable\Resources\TimetableResource;
use App\Containers\SchoolsSection\Timetable\Resources\TimetableResourceCollection;


class Timetables {

    public function resource(Timetable $timetable): TimetableResource
    {
        return new TimetableResource($timetable);
    }

    public function resourceCollection($timetables): TimetableResourceCollection
    {
        return new TimetableResourceCollection($timetables);
    }
}