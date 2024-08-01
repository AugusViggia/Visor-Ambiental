<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class PointsImport implements ToCollection
{
    protected $category_id;
    protected $subcategory_id;
    protected $ecoregion_id;
    protected $user_id;

    public function __construct(array $payload)
    {
        $this->category_id = $payload['category_id'];
        $this->subcategory_id = $payload['subcategory_id'];
        $this->ecoregion_id = $payload['ecoregion_id'];
        $this->user_id = $payload['user_id'];
    }

    public function collection(Collection $rows)
    {
        // Rellenar con lógica de ser necesario
    }
}
