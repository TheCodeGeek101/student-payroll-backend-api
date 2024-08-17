<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Containers\UsersSection\Admin\Data\Models\Adminstrator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Containers\UsersSection\Tutors\Data\Models\Tutor;
use App\Containers\UsersSection\Students\Data\Models\Student;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static function getUser($id)
    {
        return User::find($id);
    }

    public function tutor(): HasOne
    {
        return $this->hasOne(Tutor::class);
    }
    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }
    public function admin(): HasOne
    {
        return $this->hasOne(Adminstrator::class);
    }
}
