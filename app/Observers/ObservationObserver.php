<?php

namespace App\Observers;

use App\Models\Observation;
use App\Services\PointService;

class ObservationObserver
{
    private PointService $servicePoint;

    public function __construct(PointService $servicePoint)
    {
        $this->servicePoint = $servicePoint;
    }
    /**
     * Handle the Observation "created" event.
     *
     * @param  \App\Models\Observation  $observation
     * @return void
     */
    public function created(Observation $observation)
    {
        $this->servicePoint->updateByDateLastObservation($observation->point);
    }

    /**
     * Handle the Observation "updated" event.
     *
     * @param  \App\Models\Observation  $observation
     * @return void
     */
    public function updated(Observation $observation)
    {
        //
    }

    /**
     * Handle the Observation "deleted" event.
     *
     * @param  \App\Models\Observation  $observation
     * @return void
     */
    public function deleted(Observation $observation)
    {
        $this->servicePoint->updateByDateLastObservation($observation->point);

    }

    /**
     * Handle the Observation "restored" event.
     *
     * @param  \App\Models\Observation  $observation
     * @return void
     */
    public function restored(Observation $observation)
    {
        //
    }

    /**
     * Handle the Observation "force deleted" event.
     *
     * @param  \App\Models\Observation  $observation
     * @return void
     */
    public function forceDeleted(Observation $observation)
    {
        //
    }
}
