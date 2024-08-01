<?php

namespace App\Services;

use App\Models\Observation;
use App\Models\Point;

class ObservationService
{
    public function create($data, Point $point)
    {
        $point->observations()->create($data);
    }

    public function delete(Observation $observation)
    {
        $observation->delete();
    }

    public function getLast(Point $point)
    {
        return $point->observations()->orderBy('date', 'desc')->get()->first();
    }
}
