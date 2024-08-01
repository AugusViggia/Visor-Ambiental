<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\CsvSeeder as Seeder;

class StatusSeeder extends Seeder
{
    protected $filePath = '/database/data/status.csv';
    protected $model = Status::class;
}
