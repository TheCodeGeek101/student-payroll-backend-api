<?php

namespace App\Containers\SchoolsSection\Events\Data\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_name',
        'start_date',
        'end_date',
        'description',
        'location',
        'is_recurring', // Optional: To indicate if the event repeats
        'recurrence_pattern', // Optional: e.g., daily, weekly, monthly
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_recurring' => 'boolean',
    ];

    // Optional: Add relationships if needed
    // public function events()
    // {
    //     return $this->hasMany(Event::class);
    // }
}
