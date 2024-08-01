<?php

namespace App\Services;

use App\Models\Point;
use App\Models\User;
use Illuminate\Support\Collection;
use App\Jobs\InsertMissingPointObservations;
use MatanYadaev\EloquentSpatial\Objects\Point as PointSpatial;

class PointService
{
    public function get($search = [])
    {
        $query = Point::with([
            'ecoregion', 'category', 'subcategory', 'status', 'user',
            'observations' => function ($query) {
                return $query->orderBy('date', 'desc');
            }
        ]);

        $points = $query->mainSearch(collect($search))
            ->orderBy('updated_at', 'desc')
            ->paginate(config('custom.pagination.default_limit'))
            ->withQueryString();
        return $points;
    }

    public function createPoint($data, $user)
    {

        $data['location'] = new PointSpatial($data['latitude'], $data['longitude']);
        $data['user_id'] = $user->id;

        // Save first observation

        if (!empty($data['observations'])) {
            $firstObservation =  $data['observations'][0];
            $data['description'] = $firstObservation['description'];
            $data['taxa'] = $firstObservation['taxa'];
            $data['date'] = $firstObservation['date'];
        }

        Point::create($data);
    }

    public function updatePoint(Point $point, $data)
    {
        $data['location'] = new PointSpatial($data['latitude'], $data['longitude']);
        $point->update($data);
    }

    public function import(Collection $points)
    {
        Point::insertOrIgnore($points->toArray());
        InsertMissingPointObservations::dispatch();
    }

    public function approve(Point $point, User $approvingUser)
    {
        $point->status_id = config('custom.points.status.approved');
        $point->approved_by = $approvingUser->id;
        $point->save();
    }

    public function reject(Point $point, User $rejectingUser)
    {
        $point->status_id = config('custom.points.status.rejected');
        $point->rejected_by = $rejectingUser->id;
        $point->save();
    }

    public function updateByDateLastObservation(Point $point)
    {
        $observationService = app()->make(ObservationService::class);
        $observation = $observationService->getLast($point);

        $point->update([
            'description' => $observation->description ?? null,
            'taxa' => $observation->taxa ?? null,
            'date' => $observation->date ?? null
        ]);
    }

    public function changeStatusPointUserByObservation($point)
    {
        if (
            $point->status_id === config('custom.points.status.approved') ||
            $point->status_id === config('custom.points.status.denounced')
        ) {
            $point->update(['status_id' => config('custom.points.status.pending')]);
        };
    }

    public function changeStatusPointAdminByObservation($point)
    {
        if ($point->status_id === config('custom.points.status.denounced')) {
            $point->update(['status_id' => config('custom.points.status.approved')]);
        };
    }

    public function report(Point $point, User $reportingUser, $reason)
    {
        $point->status_id = config('custom.points.status.denounced');
        $point->denounced_by = $reportingUser->id;
        $point->reason = $reason;
        $point->save();
    }

    public function setPending(Point $point)
    {
        $point->status_id = config('custom.points.status.pending');
        $point->save();
    }
}
