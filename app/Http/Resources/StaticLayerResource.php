<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class StaticLayerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $content = json_decode(Storage::get($this['file']), true);
        return [
            'id' => $this['id'],
            'name' => $this['name'],
            'color' => $this['color'],
            'content' => !empty($request['load']) ? $content : null,
        ];
    }
}
