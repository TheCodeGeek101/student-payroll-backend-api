<?php
namespace App\Containers\UsersSection\Admin\Data\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Adminstrator extends Model
{
    use HasFactory;

    protected $table = 'adminstrators';

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
        'emergency_contact_relationship',
        'emergency_contact_phone',
        'emergency_contact_email',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
