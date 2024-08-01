<?php

namespace Database\Seeders;

use App\Models\Ecoregion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\CsvSeeder as Seeder;

class EcoregionSeeder extends Seeder
{
    protected $filePath = '/database/data/ecoregions.csv';
    protected $model = Ecoregion::class;
}
