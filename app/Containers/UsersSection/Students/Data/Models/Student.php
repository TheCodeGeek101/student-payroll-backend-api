<?php
namespace App\Containers\UsersSection\Students\Data\Models;

use App\Containers\SchoolsSection\Class\Data\Models\ClassModel;
use App\Containers\SchoolsSection\Grades\Data\Models\Grade;
use App\Containers\UsersSection\Guardians\Data\Models\Guardian;
use App\Containers\UsersSection\Tutors\Data\Models\Tutor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Containers\FinancialSection\Payments\Data\Models\Payment;
use App\Containers\SchoolsSection\Subjects\Data\Models\Subject;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = [
        'full_name',
    ];

    protected $fillable = [
        'registration_number',
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'phone_number',
        'email',
        'address',
        'postal_address',
        'guardian_name',
        'guardian_contact',
        'admission_date',
        'emergency_contact',
        'previous_school',
        'medical_info',
        'class_id',
        'previous_class_id', // Newly added field
        'user_id',
        'registered_by',
        'has_promoted' // Newly added field
    ];

    public function guardian(): BelongsTo
    {
        return $this->belongsTo(Guardian::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function tutors(): BelongsToMany
    {
        return $this->belongsToMany(Tutor::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class, 'student_id');
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'student_subject');
    }

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(ClassModel::class);
    }
}
