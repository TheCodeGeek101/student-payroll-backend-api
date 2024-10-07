<?php

namespace App\Containers\SchoolsSection\Timetable\Data\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Containers\UsersSection\Tutors\Data\Models\Tutor;
use App\Containers\SchoolsSection\Class\Data\Models\ClassModel;
use App\Containers\SchoolsSection\Subjects\Data\Models\Subject;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Timetable extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'subject_id',
        'tutor_id',
        'day_of_week',
        'start_time',
        'end_time',
        'classroom_id',
    ];

    /**
     * Get the subject associated with the timetable.
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the tutor associated with the timetable.
     */
    public function tutor(): BelongsTo
    {
        return $this->belongsTo(Tutor::class);
    }

    /**
     * Get the classroom associated with the timetable.
     */
    public function classroom(): BelongsTo
    {
        return $this->belongsTo(ClassModel::class);
    }
}
