<?php


namespace App\Containers\UsersSection\Adminstrator\Data\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Admin extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'phone_number',
        'date_of_birth',
        'gender',
        'street',
        'city',
        'state',
        'postal_code',
        'country',
        'profile_picture',
        'employee_id',
        'position',
        'department',
        'date_of_hire',
        'employment_type',
        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_contact_email',
        'user_id'
    ];

    /**
     * Get the user that owns the admin.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
