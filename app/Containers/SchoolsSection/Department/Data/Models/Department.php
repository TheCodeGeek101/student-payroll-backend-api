<?php
namespace App\Containers\SchoolsSection\Department\Data\Models;

use App\Containers\UsersSection\Tutors\Data\Models\Tutor;
use App\Containers\SchoolsSection\Subjects\Data\Models\Subject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;
    protected $table = 'departments';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'head_of_department',
        'description',
    ];

    /**
     * Get the tutors for the department.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tutors(): HasMany
    {
        return $this->hasMany(Tutor::class);
    }

    /**
     * Get the subjects for the department.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class);
    }
    // In Department.php (Model)
    public function headOfDepartment()
    {
        return $this->belongsTo(Tutor::class, 'head_of_department_id'); // Adjust based on your actual relationship
    }


}
