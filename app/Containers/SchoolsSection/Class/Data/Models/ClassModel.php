<?php

namespace App\Containers\SchoolsSection\Class\Data\Models;

use App\Containers\UsersSection\Tutors\Data\Models\Tutor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Containers\SchoolsSection\Subjects\Data\Models\Subject;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'classroom'; // Ensure this matches your migration table name

    protected $fillable = [
        'name',
        'description',
        'schedule',
        'term',
        'capacity',
        'subject_id',
        'room',
        'status',
        'tutor_id'
    ];

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function tutor(): BelongsTo
    {
        return $this->belongsTo(Tutor::class);
    }
}
