<?php

namespace App\Containers\SchoolsSection\Term\Data\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Containers\SchoolsSection\Term\Data\Models\Term;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Containers\SchoolsSection\Events\Data\Models\Event;

class AcademicCalendar extends Model
{
    use HasFactory;

    protected $table = 'academic_calendars';

    protected $fillable = [
        'term_id',
        'start_date',
        'end_date',
        'name',
        'description',
        'is_active'
    ];

    public function terms(): HasMany
    {
        return $this->hasMany(Term::class,'term_id');
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}

