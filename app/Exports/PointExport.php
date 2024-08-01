<?php

namespace App\Exports;

use App\Models\Point;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PointExport implements FromCollection, WithHeadings
{
    use Exportable;

    protected $data;

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function collection()
    {
        $points = Point::with([
            'ecoregion', 'category', 'subcategory', 'status', 'user',
            'observations' => function ($query) {
                return $query->orderBy('date', 'desc');
            }
        ])->mainSearch(collect($this->data))
            ->orderBy('created_at', 'desc')->get();

        return $points->map(function ($point) {
            return[
                'id' => $point->id,
                'title' => $point->title,
                'description' => $point->description,
                'ecoregion' => $point->ecoregion->name,
                'category' => $point->category->name,
                'subcategory' => $point->subcategory->name,
                'source' => $point->source,
                'altitude' => $point->altitude,
                'user' => $point->user->name,
                'status' => $point->status->name,
                'date' => $point->created_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Punto',
            'Título',
            'Descripción',
            'Ecoregión',
            'Categoría',
            'Subcategoría',
            'Fuente',
            'Altura',
            'Usuario',
            'Estado',
            'Fecha'
        ];
    }
}
