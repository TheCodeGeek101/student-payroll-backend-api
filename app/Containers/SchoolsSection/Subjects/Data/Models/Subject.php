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
    protected $fillable = [

    ];
    /**
     * The students that belong to the subject.
     *
     * @return BelongsToMany
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'student_subject');
    }

    /**
     * The tutors that belong to the subject.
     *
     * @return BelongsToMany
     */
    public function tutors(): BelongsToMany
    {
        return $this->belongsToMany(Tutor::class, 'subject_tutor');
    }

    /**
     * The grades associated with the subject.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
