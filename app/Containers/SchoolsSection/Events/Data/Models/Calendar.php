<?php

namespace App\Containers\SchoolsSection\Events\Data\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Containers\SchoolsSection\Term\Data\Models\Term;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Calendar extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'term_id',
        'start_date',
        'end_date',
        'description',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    // Optional: Add relationships if needed
    // public function events()
    // {
    //     return $this->hasMany(Event::class);
    // }

    public function terms(): BelongsTo
    {
        return $this->belongsTo(Term::class, 'term_id');
    }
}
