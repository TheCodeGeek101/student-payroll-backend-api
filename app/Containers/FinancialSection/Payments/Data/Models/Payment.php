<?php 

namespace App\Containers\FinancialSection\Payments\Data\Models;

use App\Containers\UsersSection\Students\Data\Models\Student;
use App\Containers\UsersSection\Admin\Data\Models\Adminstrator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Containers\SchoolsSection\Term\Data\Models\Term;
use App\Containers\SchoolsSection\Class\Data\Models\ClassModel;
use OwenIt\Auditing\Auditable;

class Payment extends Model 
{
    use HasFactory;
    use Auditable;

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

    // Define the attributes to be audited
    protected $auditInclude = [
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

    // Optionally exclude specific fields from auditing
    protected $auditExclude = [
        // Add fields here if you want to exclude them from the audit log
        'tx_ref'
    ];

    // Custom metadata for auditing
    public function getAuditCustomValues(): array
    {
        return [
            'ip_address' => request()->ip(), // Log IP address of the user
            'performed_by' => auth()->check() ? auth()->user()->id : 'system', // Log user or system
        ];
    }

    // Transform the audit log if needed
    public function transformAudit(array $data): array
    {
        // Add custom fields or modify the audit data
        $data['custom_field'] = 'Additional Info'; // Example of adding custom info
        return $data;
    }

    // Relationship with the Student model
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    // Access the student's full name
    public function studentName()
    {
        return $this->student ? $this->student->first_name . ' ' . $this->student->last_name : null;
    }

    // Relationship with the Administrator model for confirmation
    public function confirmedBy(): BelongsTo
    {
        return $this->belongsTo(Adminstrator::class, 'confirmed_by');
    }

    // Relationship with the Term model
    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class, 'term_id');
    }

    // Relationship with the Class model
    public function studentClass(): BelongsTo
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }
}
