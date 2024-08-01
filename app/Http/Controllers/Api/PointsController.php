<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Points\StoreImportacionRequest;
use App\Http\Requests\StoreObservationRequest;
use App\Models\Import;
use App\Services\ImportService;
use App\Jobs\ImportData;
use App\Http\Resources\PointAsGeoJsonFeatureCollection;
use App\Models\Point;
use App\Models\Status;
use Illuminate\Support\Facades\DB;

class PointsController extends Controller
{
    /**
     * @return PointAsGeoJsonFeatureCollection
     */
    public function geojson()
    {
        $points = Point::with(['ecoregion', 'category', 'subcategory.category',])
            ->mainSearch(collect(['status_id' => config('custom.points.status.approved')]))
            ->get();

        return new PointAsGeoJsonFeatureCollection($points);
    }

    public function processObservation(StoreObservationRequest $request)
    {

        return $request->validated();
    }

    public function import(StoreImportacionRequest $request)
    {
        $data = $request->validated();

        $startTime = now();

        $payload = [
            'category_id' => $data['category_id'],
            'subcategory_id' => $data['subcategory_id'],
            'ecoregion_id' => $data['ecoregion_id'],
            'user_id' => auth()->user()->id,
        ];

        $import = new Import([
            'user_id' => auth()->user()->id,
            'importable_type' => Point::class,
            'file' => $data['file']->store(config('custom.imports.folders.import_csv_files')),
            'payload' => json_encode($payload),
        ]);

        $service = app()->make(ImportService::class, [
            'import' => $import,
        ]);

        try {
            $service->processFile();
        } catch (\Throwable $th) {
            logger()->error($th);
            abort(500, 'Error al procesar el archivo');
            return;
        }

        if ($service->processHasFails()) {
            return response()->json([
                'csv' => $service->getFailedCsv(),
                'start_time' => $startTime,
                'end_time' => now(),
                'failed_rows_count' => $service->getFailedRowCount(),
            ], 400);
        }

        ImportData::dispatch($service->getProcessedModels(), Point::class);

        $import->save();

        return response()->json([
            'import' => $import,
            'start_time' => $startTime,
            'end_time' => now(),
        ]);
    }

    public function getStatsUser($id)
    {
        //Cantidad de puntos del respectivo usuario

        $query = Point::where('user_id', $id);
        $total = $query->count();

        //Puntos aprobados
        $count = $query->whereRelation('status', 'id', config('custom.points.status.approved'))->count();

        //Estado aprobado
        $status =  Status::find(config('custom.points.status.approved'));

        $stat = [ 'id' => $status->id, 'name' => $status->name, 'count' => $count ];

        return ['stats' => [$stat] , 'total' => $total];
    }

    public function getStatsAdmin()
    {
        $stats =  DB::table('status')->leftJoin('points', 'status.id', '=', 'points.status_id')
            ->select('status.id', 'status.name', DB::raw('count(points.status_id) AS count'))
            ->groupBy('status.id')->get();

        return [
            'stats' => $stats,
            'total' => $stats->sum('count')
        ];
    }
}
