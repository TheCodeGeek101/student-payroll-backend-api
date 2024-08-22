<?php
namespace App\Containers\SchoolsSection\Grades\Data\Models;

use App\Containers\SchoolsSection\Assessments\Data\Models\Assessment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Containers\SchoolsSection\Term\Data\Models\Term;
class Grade extends Model
{
    use HasFactory;

    protected $table = 'grades';

    protected $fillable = [
        'tutor_id',
        'student_id',
        'subject_id',
        'term_id',
        'score',
        'total_marks',
        'grade',
        'grade_value',
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

    public function terms(): BelongsTo
    {
        return $this->belongsTo(Term::class, 'term_id');
    }
}
