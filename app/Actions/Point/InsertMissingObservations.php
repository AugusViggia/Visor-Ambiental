<?php

namespace App\Actions\Point;

use Illuminate\Support\Facades\DB;

class InsertMissingObservations
{
    public function __construct()
    {
        $this->handle();
    }

    protected function handle()
    {
        $query = "INSERT INTO observations
        (point_id, date, description, taxa)
        select p.id, p.date, p.description, p.taxa
        from points p
        WHERE NOT EXISTS (SELECT * from observations o where o.point_id = p.id)
        AND p.date IS NOT NULL
        AND p.description IS NOT NULL";
        DB::insert($query);
    }
}
