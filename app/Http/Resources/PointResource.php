<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PointResource extends JsonResource
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
            'id' => $this->id,
            'resource_id' => $this->resource_id,
            'title' => $this->title,
            'description' => $this->description,
            'ecoregion' => new EcoregionResource($this->whenLoaded('ecoregion')),
            'category' => new CategoryResource($this->whenLoaded('category')),
            'geometry' => new GeometryResource($this->whenLoaded('geometry')),
            'subcategory' => new SubcategoryResource($this->whenLoaded('subcategory')),
            'observations' =>  ObservationResource::collection($this->whenLoaded('observations')),
            'user' => new UserResource($this->whenLoaded('user')),
            'source' => $this->source,
            'reason' => $this->reason,
            'institution' => $this->institution,
            'url' => $this->url,
            'altitude' => $this->altitude,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'status' => new StatusResource($this->whenLoaded('status')),
            'date_last_modified' => $this->updated_at,
            'can_update' => Gate::inspect('update', $this->resource)->allowed(),
            'can_delete' => Gate::inspect('delete', $this->resource)->allowed(),
            'read_only' => Gate::inspect('readOnly', $this->resource)->allowed()
        ];
    }
}
