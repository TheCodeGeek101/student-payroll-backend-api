<?php

namespace App\Containers\SchoolsSection\Term\Data\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Containers\SchoolsSection\Grades\Data\Models\Grade;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Term extends Model
{
    use HasFactory;

    protected $table = 'terms';

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'description'
    ];

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

}
