<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\CsvSeeder as Seeder;

class CategorySeeder extends Seeder
{
    protected $filePath = '/database/data/categories.csv';
    protected $model = Category::class;
}
