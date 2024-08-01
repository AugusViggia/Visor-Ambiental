<?php

namespace Database\Seeders;

use App\Models\Subcategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\CsvSeeder as Seeder;

class SubcategorySeeder extends Seeder
{
    protected $filePath = '/database/data/subcategories.csv';
    protected $model = Subcategory::class;
}
