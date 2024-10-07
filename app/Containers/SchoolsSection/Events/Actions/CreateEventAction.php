<?php

namespace App\Containers\SchoolsSection\Events\Actions;
use Illuminate\Support\Facades\DB;
use App\Containers\SchoolsSection\Events\Requests\StoreEventRequest;
use App\Containers\SchoolsSection\Events\Data\Models\Event;
use App\Ship\Actions\Action;
use Exception;

class CreateEventAction extends Action
{

    public function run(StoreEventRequest $request)
    {
        try{
            $event = null;
            DB::transaction(function () use ($request, &$event) {
                $event = Event::create($request->validated());
            }); 
            return $event;
        }
        catch(Exception $e){
            return [
                'message' => $e->getMessage(),
            ];
        }
    }
}