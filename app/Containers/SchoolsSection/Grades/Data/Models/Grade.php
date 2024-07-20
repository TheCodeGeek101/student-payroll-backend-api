<?php


namespace App\Containers\SchoolsSection\Grades\Data\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'tutor_id',
        'student_id',
        'subject_id',
        'grade',
        'comments',
        'graded_at',
    ];

    public function initiator(): BelongsTo
    {
        return $this->belongsTo(Tutor::class, 'tutor_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}
