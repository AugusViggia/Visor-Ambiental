<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observation extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'description',
        'taxa',
    ];

    public function point()
    {
        return $this->belongsTo(Point::class);
    }
}
