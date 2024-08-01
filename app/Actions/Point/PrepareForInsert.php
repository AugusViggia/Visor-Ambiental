<?php

namespace App\Actions\Point;

use App\Models\Point;
use Illuminate\Support\Str;
use App\Actions\HashModel;

class PrepareForInsert
{
    public function asArray(array $point): array
    {
        $point['resource_id'] = $this->generateUuid();
        $point['hash'] = $this->generateHash(new Point($point));
        $point['status_id'] = $this->getStatusId(new Point($point));
        $point['location'] = ($point['location'])->toWkt();
        $point['created_at'] = now();
        $point['updated_at'] = now();
        return $point;
    }

    public function asModel(Point $point): Point
    {
        $point->resource_id = $this->generateUuid();
        $point->hash = $this->generateHash($point);
        $point->status_id = $this->getStatusId($point);
        $point->created_at = now();
        $point->updated_at = now();
        return $point;
    }

    protected function generateUuid(): string
    {
        return Str::uuid();
    }

    protected function generateHash(Point $point): string
    {
        return (app()->make(HashModel::class, [
            'model' => $point,
        ]))->getHash();
    }

    protected function getStatusId(Point $point): int
    {
        if ($point->user->can('points.approve')) {
            return config('custom.points.status.approved');
        }
        return config('custom.points.status.pending');
    }
}
