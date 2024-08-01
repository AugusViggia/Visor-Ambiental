<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\EcoregionResource;
use App\Http\Resources\StaticLayerResource;
use App\Models\Category;
use App\Models\Ecoregion;
use App\Models\Point;
use App\Http\Requests\Points\ReportRequest;
use Inertia\Inertia;
use App\Jobs\NotifyPointWasReported;
use App\Services\Helpers\Alert\AlertType;
use App\Services\PointService;

class MapController extends Controller
{
    public function index()
    {
        return Inertia::render(
            'Map',
            [
                'categories' => CategoryResource::collection(
                    Category::with('subcategories.category')->get()
                ),
                'ecoregions' => EcoregionResource::collection(Ecoregion::all()),
                'staticLayers' => StaticLayerResource::collection(collect(config('custom.map.statics_layer_sources'))),
            ]
        );
    }

    public function denounce(Point $point, ReportRequest $request, PointService $service)
    {
        $data = $request->validated();
        try {
            $service->report($point, auth()->user(), $data['reason']);
        } catch (\Exception $th) {
            logger()->error($th->getMessage());
            flashAlert(
                __('messages.failure', ['action' => 'Denuncia', 'element' => 'Punto']),
                AlertType::DANGER
            );
            return true;
        }
        NotifyPointWasReported::dispatch($point, $data['reason']);
        flashAlert(__('messages.success', ['Action' => 'Denuncia', 'element' => 'Punto']));
        return true;
    }
}
