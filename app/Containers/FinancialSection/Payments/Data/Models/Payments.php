<?php

namespace App\Containers\FinancialSection\Payments\Data\Models;

use App\Containers\UsersSection\Students\Data\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function student(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
    public function receivedBy()
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    public function confirmedBy()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }


}
