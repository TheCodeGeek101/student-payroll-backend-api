<?php

namespace App\Containers\SchoolsSection\Grades\Data\Models;

use App\Containers\SchoolsSection\Assessments\Data\Models\Assessment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Containers\SchoolsSection\Term\Data\Models\Term;
use App\Containers\SchoolsSection\Class\Data\Models\ClassModel;
use App\Containers\SchoolsSection\Subjects\Data\Models\Subject;
use App\Containers\UsersSection\Students\Data\Models\Student;
use App\Containers\UsersSection\Tutors\Data\Models\Tutor;
use OwenIt\Auditing\Contracts\Auditable; // Include the Auditable contract

class Grade extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable; // Use the Auditable trait

    protected $table = 'grades';

    // Fillable attributes
    protected $fillable = [
        'tutor_id',
        'student_id',
        'subject_id',
        'class_id',
        'term_id',
        'score',
        'total_marks',
        'grade',
        'grade_value',
        'comments',
        'graded_at',
    ];

    // Define the attributes to be audited
    protected $auditInclude = [
        'tutor_id',
        'student_id',
        'subject_id',
        'class_id',
        'term_id',
        'score',
        'total_marks',
        'grade',
        'grade_value',
        'comments',
        'graded_at',
    ];

    // Relationship with Tutor model (initiator)
    public function initiator(): BelongsTo
    {
        return $this->belongsTo(Tutor::class, 'tutor_id');
    }

    // Relationship with Student model
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    // Relationship with Subject model
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    // Relationship with Term model
    public function terms(): BelongsTo
    {
        return $this->belongsTo(Term::class, 'term_id');
    }

    // Relationship with Class model
    public function class(): BelongsTo
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }
}
