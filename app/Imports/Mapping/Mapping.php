<?php

namespace App\Imports\Mapping;

abstract class Mapping
{
    public array $row;
    public array $mapped;

    public function __construct(array $row)
    {
        $this->row = $row;
        $this->mapped = $this->mapData();
    }

    protected function mapData()
    {
        $mapped = [];
        foreach ($this->map as $key => $value) {
            $mapped[$value] = $this->row[$key];
        }
        return $mapped;
    }

    public function getMapped()
    {
        return $this->mapped;
    }
}
