<?php


namespace App\Containers\SchoolsSection\Subjects\Data\Models;

use App\Containers\SchoolsSection\Grades\Data\Models\Grade;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Containers\UsersSection\Students\Data\Models\Student;
use App\Containers\UsersSection\Tutors\Data\Models\Tutor;

class Subject extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'student_subject');
    }

    public function tutors(): BelongsToMany
    {
        return $this->belongsToMany(Tutor::class, 'subject_tutor');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class, 'subject_id');
    }
}

