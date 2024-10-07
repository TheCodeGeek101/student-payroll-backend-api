<?php

namespace App\Containers\SchoolsSection\Events\Data\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_name',
       'event_date'
    ];

    protected $casts = [
        
    ];

    // Optional: Add relationships if needed
    // public function events()
    // {
    //     return $this->hasMany(Event::class);
    // }
}
