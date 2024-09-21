<?php

namespace App\Containers\SchoolsSection\Events\Actions;

use App\Ship\Actions\Action;
use App\Containers\SchoolsSection\Events\Data\Models\Calendar;
use Illuminate\Support\Facades\DB;
use App\Containers\SchoolsSection\Events\Requests\StoreCalendarRequest;

class CreateSchoolCalendarAction extends Action
{
    public function run(StoreCalendarRequest $request)
    {
        $calendar = null;
        DB::transaction(function () use ($request, &$calendar) {
            $calendar = Calendar::create($request->validated());
        });
        return $calendar;
    }
}
