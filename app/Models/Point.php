<?php

namespace App\Models;

use App\Services\Values\Marker;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MatanYadaev\EloquentSpatial\Objects\Point as SpatialPoint;
use MatanYadaev\EloquentSpatial\SpatialBuilder;

class Point extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'institution',
        'source',
        'url',
        'date',
        'geometry_id',
        'altitude',
        'category_id',
        'subcategory_id',
        'ecoregion_id',
        'location',
        'taxa',
        'user_id',
        'status_id',
        'hash',
        'reason',
    ];

    protected $casts = [
        'location' => SpatialPoint::class,
    ];

    public array $fieldsForHash = [
        'title',
        'description',
        'institution',
        'source',
        'url',
        'altitude',
        'geometry_id',
        'category_id',
        'subcategory_id',
        'ecoregion_id',
        'location',
        'taxa',
    ];

    public function newEloquentBuilder($query): SpatialBuilder
    {
        return new SpatialBuilder($query);
    }

    public function ecoregion()
    {
        return $this->belongsTo(Ecoregion::class);
    }

    public function geometry()
    {
        return $this->belongsTo(Geometry::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function observations()
    {
        return $this->hasMany(Observation::class);
    }

    public function scopeMainSearch($query, $data)
    {
        if ($data->get('title')) {
            $query->where('title', 'LIKE', '%' . $data->get('title') . '%');
        }

        if ($data->get('category_id') !== null) {
            $query =  $query->where('category_id', $data->get('category_id'));
        }

        if ($data->get('subcategory_id') !== null) {
            $query = $query->where('subcategory_id', $data->get('subcategory_id'));
        }

        if ($data->get('ecoregion_id') !== null) {
            $query = $query->where('ecoregion_id', $data->get('ecoregion_id'));
        }

        if ($data->get('status_id') !== null) {
            $query =  $query->where('status_id', $data->get('status_id'));
        }

        if ($data->get('user_id') !== null) {
            $query =  $query->where('user_id', $data->get('user_id'));
        }

        if ($data->get('date_from')) {
            $query = $query->whereDate('updated_at', '>=', $data->get('date_from'));
        }

        if ($data->get('date_to')) {
            $query = $query->whereDate('updated_at', '<=', $data->get('date_to'));
        }

        return $query;
    }

    public function marker(): Attribute
    {
        return Attribute::make(
            get: fn () => new Marker([
                $this->category->name,
                optional($this->subcategory)->name,
            ])
        );
    }

    public function latitude(): Attribute
    {


        return Attribute::make(
            get: fn () => $this->location ? $this->location->latitude : null
        );
    }

    public function longitude(): Attribute
    {

        return Attribute::make(
            get: fn () => $this->location ? $this->location->longitude : null
        );
    }

    public function wasApproved(): Attribute
    {

        return Attribute::make(
            get: fn () => $this->approved_by !== null ? true : false
        );
    }
}
