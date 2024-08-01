<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function slug(): Attribute
    {
        $categorySlug = '';
        if ($this->relationLoaded('category')) {
            $categorySlug = $this->category->slug . '-';
        }
        return Attribute::make(
            get: fn ($value, $attributes) => $categorySlug . str($attributes['name'])->slug()
        );
    }
}
