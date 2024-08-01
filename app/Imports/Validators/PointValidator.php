<?php

namespace App\Imports\Validators;

use MatanYadaev\EloquentSpatial\Objects\Point as GeospatialPoint;
use App\Models\Geometry;
use App\Imports\Mapping\PointMapping;
use Illuminate\Support\Facades\Validator;
use App\Actions\Point\PrepareForInsert;
use App\Rules\ValidLatitude;
use App\Rules\ValidLongitude;

class PointValidator
{
    protected $payload;
    protected array $validatedData;
    protected array $validationErrors;

    protected $paramsNames = [
        'title' => 'Título',
        'description' => 'Descripción',
        'institution' => 'Institución',
        'source' => 'Fuente',
        'url' => 'URL',
        'geometry_id' => 'Geometría',
        'category_id' => 'Categoría',
        'subcategory_id' => 'Subcategoría',
        'ecoregion_id' => 'Ecoregión',
        'location' => 'Coordenadas',
        'user_id' => 'Usuario',
        'status_id' => 'Estado',
        'latitude' => 'Latitud',
        'longitude' => 'Longitud',
        'altitude' => 'Altura (msnm)',
        'taxa' => 'Taxones',
        'date' => 'Fecha',
    ];

    protected array $rules;

    public function __construct(array $payload)
    {
        $this->setRules();
        $mappedData = collect((app()->make(PointMapping::class, [
            'row' => $payload,
        ]))->getMapped());

        $geometry = Geometry::where('name', $mappedData->get('geometry'))->first();
        $mappedData->put('geometry_id', $geometry?->id);
        $mappedData->forget('geometry');

        $this->payload = ($mappedData->merge([
            'category_id' => $payload['category_id'],
            'subcategory_id' => $payload['subcategory_id'],
            'ecoregion_id' => $payload['ecoregion_id'],
            'user_id' => $payload['user_id'],
        ]))->toArray();
    }

    public function validate()
    {

        $validator = Validator::make($this->payload, $this->rules);
        $validator->setAttributeNames($this->paramsNames);
        if ($validator->fails()) {
            $this->validationErrors = $validator->errors()->get('*');
            return false;
        }
        $this->validatedData = $this->processSuccessValidated($this->payload);
        return true;
    }

    protected function processSuccessValidated(array $payload): array
    {
        $processedData = $payload;
        $processedData['location'] = (new GeospatialPoint($payload['latitude'], $payload['longitude']));
        $processedData['date'] = map_date($processedData['date']);
        $processedData = (app()->make(PrepareForInsert::class))->asArray($processedData);
        unset($processedData['latitude']);
        unset($processedData['longitude']);
        return $processedData;
    }

    public function getErrorsAsString(): string
    {
        $errors = [];
        foreach ($this->validationErrors as $error => $key) {
            $message = implode(', ', $key);
            $errors[$this->paramsNames[$error]] = rtrim($message, '. ');
        }
        return implode(', ', $errors);
    }

    public function getValidatedData(): array
    {
        return $this->validatedData;
    }

    private function setRules()
    {
        $this->rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|required_with:date|string|max:255',
            'institution' => 'required|string|max:255',
            'source' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'geometry_id' => 'required|exists:geometries,id',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'ecoregion_id' => 'required|exists:ecoregions,id',
            'latitude' => [
                'required',
                new ValidLatitude(),
            ],
            'longitude' => [
                'required',
                new ValidLongitude(),
            ],
            'altitude' => 'required|numeric|min:0',
            'taxa' => 'nullable|integer|min:0',
            'user_id' => 'required|exists:users,id',
            'date' => 'nullable|required_with:description|date_format:d/m/Y',
        ];
    }
}
