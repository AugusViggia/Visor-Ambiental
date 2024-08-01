<?php

namespace App\Http\Controllers;

use App\Models\Point;
use App\Services\PointService;
use App\Http\Requests\RejectPointSolicitudeRequest;
use App\Notifications\PointWasRejected;
use App\Jobs\NotifyPointWasRejected;

class PointSolicitudeController extends Controller
{
    public function approve(Point $point, PointService $service)
    {
        $service->approve($point, auth()->user());
        flashAlert(__('messages.success', ['Action' => 'Aprobación', 'element' => 'Punto']));
        return redirect()->route('points.show', $point);
    }

    public function reject(Point $point, RejectPointSolicitudeRequest $request, PointService $service)
    {
        $reason = ($request->validated())['reason'];
        $service->reject($point, auth()->user());
        NotifyPointWasRejected::dispatch($point->user, $reason);
        flashAlert(__('messages.success', ['Action' => 'Rechazo', 'element' => 'Punto']));
        return redirect()->route('points.index');
    }
}
