<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class PointAsGeoJsonFeature extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'type' => 'Feature',
            'geometry' => [
                'type' => 'Point',
                'coordinates' => [
                    $this->location->longitude,
                    $this->location->latitude
                ],
            ],
            'properties' => [
                'id' => $this->resource_id,
                'title' => $this->title,
                'description' => $this->description,
                'institution' => $this->institution,
                'ecoregion_id' => $this->ecoregion_id,
                'ecoregion' => new EcoregionResource($this->whenLoaded('ecoregion')),
                'source' => $this->source,
                'altitude' => $this->altitude,
                'url' => $this->url,
                'marker_code' => $this->marker->code(),
                'category_id' => $this->category_id,
                'subcategory_id' => $this->subcategory_id,
                'category' => new CategoryResource($this->whenLoaded('category')),
                'subcategory' => new SubcategoryResource($this->whenLoaded('subcategory')),
                'readonly' => Auth::check(),
            ],
        ];
    }
}
