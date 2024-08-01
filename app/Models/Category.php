<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }

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
