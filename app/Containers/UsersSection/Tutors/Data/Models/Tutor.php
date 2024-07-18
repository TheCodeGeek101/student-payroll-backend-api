<?php

// app/Containers/UsersSection/Tutors/Data/Models/Tutor.php

namespace App\Containers\UsersSection\Tutors\Data\Models;

use App\Containers\UsersSection\Guardians\Data\Models\Guardian;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Containers\SchoolsSection\Subjects\Data\Models\Subject;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Tutor extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'hire_date',
        'department',
        'bio',
        'user_id'
    ];

    /**
     * The subjects that belong to the tutor.
     */
    public function getFullNameAttribute(): string
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
}

