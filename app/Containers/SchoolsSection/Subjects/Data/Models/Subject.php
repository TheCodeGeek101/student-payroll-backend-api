<?php

namespace App\Containers\SchoolsSection\Subjects\Data\Models;

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
        return $this->belongsToMany(Student::class);
    }

    public function tutors(): BelongsToMany
    {
        return $this->belongsToMany(Tutor::class);
    }
}
