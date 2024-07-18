<?php

namespace App\Containers\UsersSection\Students\Data\Models;

use App\Containers\SchoolsSection\Grades\Data\Models\Grades;
use App\Containers\UsersSection\Guardians\Data\Models\Guardian;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Containers\FinancialSection\Payments\Data\Models\Payments;
use App\Containers\SchoolsSection\Subjects\Data\Models\Subject;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    use HasFactory;

    public mixed $email;

    protected $guarded = [];

    protected $appends = [
        'full_name',
    ];

    public function guardian(): BelongsTo
    {
        return $this->belongsTo(Guardian::class);
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function payments()
    {
        return $this->hasMany(Payments::class);
    }

    public function grades()
    {
        return $this->hasMany(Grades::class);
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class);
    }
}
