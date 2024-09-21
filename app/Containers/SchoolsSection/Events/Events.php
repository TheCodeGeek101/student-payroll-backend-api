<?php

namespace App\Containers\SchoolsSection\Events;

use App\Containers\SchoolsSection\Events\Data\Models\Event;
use App\Containers\SchoolsSection\Events\Resources\EventResource;
use App\Containers\SchoolsSection\Events\Resources\EventResourceCollection;

class Events
{
    public function resource(Event $event): EventResource
    {
        return new EventResource($event);
    }

    public function resourceCollection($events): EventResourceCollection
    {
        return new EventResourceCollection($events);
    }
}
