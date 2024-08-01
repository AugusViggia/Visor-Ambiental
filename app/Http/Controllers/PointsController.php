<?php

namespace App\Http\Controllers;

use App\Exports\PointExport;
use App\Http\Requests\SearchPointRequest;
use App\Http\Requests\StorePointRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\EcoregionResource;
use App\Http\Resources\GeometryResource;
use App\Http\Resources\PointResource;
use App\Http\Resources\StatusResource;
use App\Http\Resources\SubcategoryResource;
use App\Models\Category;
use App\Models\Ecoregion;
use App\Models\Geometry;
use App\Models\Point;
use App\Models\Status;
use App\Models\Subcategory;
use App\Services\Helpers\Alert\AlertType;
use App\Services\PointService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class PointsController extends Controller
{
    public function index(SearchPointRequest $request, PointService $service)
    {

        $data = $request->validated();
        //Para filtrar los puntos de un usuario en especifico
        if (Auth::check() && Gate::allows('isUser')) {
            $data['user_id'] = Auth::user()->id;
        }

        $points = $service->get($data);

        return Inertia::render('Points/PointRequests', [
            'points' => PointResource::collection($points),
            'categories' => CategoryResource::collection(Category::all()),
            'subCategories' => SubcategoryResource::collection(Subcategory::all()),
            'ecoregions' => EcoregionResource::collection(Ecoregion::all()),
            'statuses' => StatusResource::collection(Status::all()),
            'filters' => !empty($request->except('page')) ? $request->except('page') : null,
            'pointStatusList' => [
                'pending' => config('custom.points.status.pending'),
                'approved' => config('custom.points.status.approved'),
            ],
        ]);
    }

    public function show(Point $point)
    {
        return Inertia::render('Points/ShowPage', [
            'point' => new PointResource($point->load([
                'ecoregion',
                'category',
                'subcategory',
                'geometry',
                'observations'
            ])),
        ]);
    }

    public function process(Point $point)
    {
        return Inertia::render('Points/ProcessPage', [
            'point' => new PointResource($point->load([
                'ecoregion',
                'category',
                'subcategory',
                'geometry',
                'observations'
            ])),
        ]);
    }

    public function create()
    {

        return Inertia::render('Points/PointCreate', [
            'categories' => CategoryResource::collection(Category::orderBy('name')->get()),
            'geometries' => GeometryResource::collection(Geometry::all()),
            'subcategories' => SubcategoryResource::collection(Subcategory::all()),
            'ecoregions' => EcoregionResource::collection(Ecoregion::all()),
            'categoryIdDefault' => config('custom.points.category.category_default_id')
        ]);
    }

    public function store(StorePointRequest $request, PointService $service)
    {
        $data = $request->validated();

        try {
            $service->createPoint($data, Auth::user());
            flashAlert(__('messages.success', ['Action' => 'Creación', 'element' => 'Punto']));
        } catch (\Exception $exception) {
            logger($exception->getMessage());
            flashAlert(
                __('messages.failure', ['action' => 'Creación', 'element' => 'Punto']),
                AlertType::DANGER
            );
        }

        return redirect()->route('points.index');
    }

    public function edit(Point $point)
    {
        return Inertia::render('Points/PointEdit', [
            'point' => new PointResource($point->load(
                [
                    'ecoregion',
                    'category',
                    'subcategory',
                    'observations' => function ($query) {
                        $query->orderBy('date', 'desc');
                    },
                    'geometry'
                ]
            )),
            'categories' => CategoryResource::collection(Category::orderBy('name')->get()),
            'geometries' => GeometryResource::collection(Geometry::all()),
            'subcategories' => SubcategoryResource::collection(Subcategory::all()),
            'ecoregions' => EcoregionResource::collection(Ecoregion::all()),
            'categoryIdDefault' => config('custom.points.category.category_default_id')
        ]);
    }

    public function update(StorePointRequest $request, Point $point, PointService $service)
    {

        $data = $request->validated();

        try {
            $service->updatePoint($point, $data);
            flashAlert(__('messages.success', ['Action' => 'Actualización', 'element' => 'Punto']));
        } catch (\Exception $exception) {
            logger($exception->getMessage());
            flashAlert(
                __('messages.failure', ['action' => 'Actualización', 'element' => 'Punto']),
                AlertType::DANGER
            );
        }

        return redirect()->route('points.index');
    }

    public function delete(Point $point)
    {
        try {
            DB::beginTransaction();
            $point->observations()->delete();
            $point->delete();
            DB::commit();
            flashAlert(__('messages.success', ['Action' => 'Eliminación', 'element' => 'Punto']));
        } catch (\Exception $exception) {
            DB::rollBack();
            logger($exception->getMessage());
            flashAlert(
                __('messages.failure', ['action' => 'Eliminación', 'element' => 'Punto']),
                AlertType::WARNING
            );
        }

        return redirect()->route('points.index');
    }

    public function importPage()
    {
        if (auth()->user()->hasPendingImport) {
            return Inertia::render('Points/PendingImport');
        }

        return Inertia::render('Points/Import', [
            'categories' => CategoryResource::collection(Category::with('subcategories')->get()),
            'ecoregions' => EcoregionResource::collection(Ecoregion::all()),
        ]);
    }


    public function downloadExcelTemplate()
    {
        return response()->download(
            storage_path('app/csv/plantilla-importacion-puntos.csv'),
            'plantilla-importacion-puntos.csv'
        );
    }

    public function generateExcel()
    {
        $data = request()->all() ? request()->all()['filters'] : request()->all();
        return (new PointExport($data))->download('Points.xlsx');
    }
}
