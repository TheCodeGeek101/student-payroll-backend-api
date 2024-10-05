<?php

namespace App\Containers\SchoolsSection\Assessments\Data\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Containers\SchoolsSection\Grades\Data\Models\Grade;
use App\Containers\UsersSection\Students\Data\Models\Student;
use App\Containers\SchoolsSection\Subjects\Data\Models\Subject;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Containers\SchoolsSection\Term\Data\Models\Term;
use OwenIt\Auditing\Contracts\Auditable; // Include the Auditable contract

class Assessment extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable; // Use the Auditable trait

    protected $table = 'assessments';

    // Fillable attributes
    protected $fillable = [
        'student_id',
        'subject_id',
        'term_id',
        'class_id',
        'score',
        'total_marks',
        'grade_value',
        'comments',
        'tutor_id',
        'date',
    ];

    // Define the attributes to be audited
    protected $auditInclude = [
        'student_id',
        'subject_id',
        'term_id',
        'class_id',
        'score',
        'total_marks',
        'grade_value',
        'comments',
        'tutor_id',
        'date',
    ];

    // Relationship with Student model
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    // Relationship with Subject model
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    // Relationship with Grade model
    public function grades(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    // Relationship with Term model
    public function terms(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }
}
