<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreObservationRequest;
use App\Models\Observation;
use App\Models\Point;
use App\Services\Helpers\Alert\AlertType;
use App\Services\ObservationService;
use App\Services\PointService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ObservationsController extends Controller
{
    public function storeObservation(
        StoreObservationRequest $request,
        Point $point,
        ObservationService $serviceObservation,
        PointService $servicePoint
    ) {
        $data = $request->validated();
        try {
            $serviceObservation->create($data, $point);
            $this->changeStatusPoint($point, $servicePoint);
            flashAlert(__('messages.success', ['Action' => 'Creación', 'element' => 'Avistamiento']));
        } catch (\Exception $exception) {
            logger($exception->getMessage());
            flashAlert(
                __('messages.failure', ['action' => 'Creación', 'element' => 'Avistamiento']),
                AlertType::DANGER
            );
        }

        return redirect()->route('points.edit', $point);
    }

    public function deleteObservation(
        Observation $observation,
        ObservationService $serviceObservation,
        PointService $servicePoint
    ) {
        $this->doDelete($observation, $serviceObservation, $servicePoint, 'Eliminación');
        return redirect()->route('points.edit', $observation->point);
    }

    public function reject(
        Observation $observation,
        ObservationService $serviceObservation,
        PointService $servicePoint
    ) {
        $this->doDelete($observation, $serviceObservation, $servicePoint, 'Rechazo');
        return redirect()->route('points.process', $observation->point);
    }

    protected function doDelete(
        Observation $observation,
        ObservationService $serviceObservation,
        PointService $servicePoint,
        string $action,
    ) {
        try {
            $serviceObservation->delete($observation);
            $this->changeStatusPoint($observation->point, $servicePoint);
            flashAlert(__('messages.success', ['Action' => $action, 'element' => 'Avistamiento']));
        } catch (\Exception $exception) {
            logger($exception->getMessage());
            DB::rollback();
            flashAlert(
                __('messages.failure', ['action' => $action, 'element' => 'Avistamiento']),
                AlertType::DANGER
            );
        }
    }

    public function changeStatusPoint(Point $point, PointService $servicePoint)
    {
        if (Gate::allows('isUser')) {
            $servicePoint->changeStatusPointUserByObservation($point);
        } elseif (Gate::allows('isAdmin')) {
            $servicePoint->changeStatusPointAdminByObservation($point);
        }
    }
}
