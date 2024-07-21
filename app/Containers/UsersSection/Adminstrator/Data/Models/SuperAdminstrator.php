<?php
namespace App\Containers\UsersSection\Adminstrator\Data\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class SuperAdministrator extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'gender',
        'birthdate',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
