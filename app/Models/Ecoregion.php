<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ecoregion extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * @return Attribute
     */
    public function slug(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => str($attributes['name'])->slug()
        );
    }
}
