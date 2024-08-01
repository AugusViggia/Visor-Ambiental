<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetStaticLayerRequest;
use App\Http\Resources\StaticLayerResource;

class StaticLayersController extends Controller
{
    public function index()
    {
        return StaticLayerResource::collection(collect(config('custom.map.statics_layer_sources')));
    }

    public function show(GetStaticLayerRequest $request)
    {
        $id = $request->validated('id');
        $layer = collect(config('custom.map.statics_layer_sources'))
            ->keyBy('id')
            ->get($id);

        return new StaticLayerResource($layer);
    }
}
