<?php

namespace App\Services\Values;

use Illuminate\Support\Str;

class Marker
{
    protected $value;
    protected $mapping = [];

    public function __construct($value)
    {
        $this->value = $value;

        $this->mapping = [

        ];
    }

    public function code()
    {
        return Str::slug(
            implode(' ', $this->value)
        );
    }
}
