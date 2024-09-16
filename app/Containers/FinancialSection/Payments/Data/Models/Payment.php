<?php

namespace App\Containers\FinancialSection\Payments\Data\Models;

use App\Containers\UsersSection\Students\Data\Models\Student;
use App\Containers\UsersSection\Admin\Data\Models\Adminstrator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Containers\SchoolsSection\Term\Data\Models\Term;
use App\Containers\SchoolsSection\Class\Data\Models\ClassModel;

class Payment extends Model
{
    use HasFactory;

    // Guarded or fillable attributes as necessary
    protected $fillable = [
        'student_id',
        'class_id',
        'term_id',
        'amount',
        'payment_date',
        'title',
        'description',
        'currency',
        'confirmed',
        'tx_ref',
        'confirmed_by',
    ];

    // Relationship with the Student model
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
    public function studentName()
    {
        $student = new Student();
        return $student->first_name . '' . $student->last_name;
    }

    // Relationship with the Administrator model for confirmation
    public function confirmedBy(): BelongsTo
    {
        return $this->belongsTo(Adminstrator::class, 'confirmed_by');
    }

    public function terms(): BelongsTo
    {
        return $this->belongsTo(Term::class, 'term_id');
    }

    public function studentClass(): BelongsTo
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }
}
