<?php

namespace Database\Seeders;

use App\Models\Geometry;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\CsvSeeder as Seeder;

class GeometrySeeder extends Seeder
{
    protected $filePath = '/database/data/geometries.csv';
    protected $model = Geometry::class;
}
