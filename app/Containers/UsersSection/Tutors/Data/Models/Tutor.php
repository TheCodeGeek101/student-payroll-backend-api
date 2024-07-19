<?php

namespace App\Containers\UsersSection\Tutors\Data\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Containers\SchoolsSection\Subjects\Data\Models\Subject;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
     * Get the full name of the tutor.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * The subjects that belong to the tutor.
     *
     * @return BelongsToMany
     */
    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'subject_tutor');
    }

    /**
     * The user that the tutor belongs to.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
