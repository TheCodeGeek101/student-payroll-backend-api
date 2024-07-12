<?php

namespace App\Containers\UsersSection\Students\Data\Models;
use App\Containers\UsersSection\Guardians\Data\Models\Guardian;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    use HasFactory;

    public function guardian(): BelongsTo
    {
        return $this->belongsTo(Guardian::class);
    }
    protected $guarded = [];

    protected $appends = [
        'full_name',
    ];

    public function getFullNameAttribute(): string
    {
        return $this->first_name.' '.$this->last_name;
    }

}
