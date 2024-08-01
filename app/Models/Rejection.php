<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rejection extends Model
{
    use HasFactory;

    protected $fillable = ['reason','rejected_by'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')
            ->withTrashed();
    }

    public function userWhoApproved()
    {
        return $this->belongsTo(User::class, 'rejected_by')
            ->withTrashed();
    }
}
