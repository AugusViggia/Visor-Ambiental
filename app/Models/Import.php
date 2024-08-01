<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    use HasFactory;

    protected $table = 'imports';

    protected $fillable = [
        'user_id',
        'importable_id',
        'importable_type',
        'file',
        'payload',
        'failed_log',
        'processed_log',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
