<?php

namespace App\Imports\Mapping;

class PointMapping extends Mapping
{
    protected $map = [
        0 => 'title',
        1 => 'institution',
        2 => 'source',
        3 => 'url',
        4 => 'date',
        5 => 'description',
        6 => 'taxa',
        7 => 'geometry',
        8 => 'latitude',
        9 => 'longitude',
        10 => 'altitude',
    ];
}
