<?php 


namespace App\Containers\SchoolsSection\Events\Actions;

use App\Containers\SchoolsSection\Events\Data\Models\Calendar;
use App\Ship\Actions\Action;
use App\Containers\SchoolsSection\Events\Requests\StoreCalendarRequest;
use Illuminate\Support\Facades\DB;


class CreateCalendarAction extends Action
{

    public function run(StoreCalendarRequest $request)
    {
        try
        {
            $calendar = null;
        DB::transaction(function () use ($request, &$calendar){
            $calendar = Calendar::create($request->validated());
        });
            return $calendar;
        }
        catch(\Exception $e){
            return $e->getMessage();
        }
    }
}