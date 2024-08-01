<?php

namespace App\Observers;

use App\Models\Point;
use App\Actions\Point\PrepareForInsert;
use App\Services\PointService;
use Illuminate\Support\Facades\Gate;

class PointObserver
{
    private PointService $servicePoint;

    public function __construct(PointService $servicePoint)
    {
        $this->servicePoint = $servicePoint;
    }
    public function creating(Point $model)
    {
        $model = (app()->make(PrepareForInsert::class))->asModel($model);
    }

    public function created(Point $model)
    {
        if ($model->date && $model->description) {
            $model->observations()->create([
                'date' => $model->date,
                'description' => $model->description,
                'taxa' => $model->taxa,
            ]);
        }
    }

    /**
     * Listen to the Point updating event.
     *
     * @param  \App\Models\Point  $point
     * @return void
     */
    public function updating(Point $point)
    {
        $fields = [
            'title',
            'source',
            'institution',
            'url',
            'geometry_id',
            'altitude',
            'category_id',
            'subcategory_id',
            'ecoregion_id',
            'location',
            'taxa',
            'date',
            'description',
        ];

        if (!$point->isDirty($fields)) {
            return;
        }

        Point::withoutEvents(function () use ($point) {
            $updater = auth()->user();
            if ($updater->can('points.approve')) {
                $this->servicePoint->approve($point, $updater);
            } else {
                $this->servicePoint->setPending($point);
            }
        });
    }
}
