<?php

namespace App\Services;

use App\Models\Import;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection;
use League\Csv\Writer;
use SplTempFileObject;

class ImportService
{
    protected Import $import;
    private Collection $processedRows;
    private Collection $processedModels;
    private Collection $failed;
    private Collection $sheetHeader;
    protected array $payload;
    protected string $file;

    public function __construct(Import $import)
    {
        $this->import = $import;
        $this->payload = json_decode($this->import->payload, true);
        $this->processedRows = collect();
        $this->processedModels = collect();
        $this->failed = collect();
    }

    protected function getImportModel(): string
    {
        return $this->import->importable_type;
    }

    protected function getImportClass(): string
    {
        return config('custom.imports.models_imports.' . $this->import->importable_type);
    }

    protected function getValidatorRowClass(): string
    {
        return config('custom.imports.models_import_validators.' . $this->import->importable_type);
    }

    protected function getFile(): string
    {
        return $this->import->file;
    }

    public function processFile()
    {
        $importClass = $this->getImportClass();
        $collectionOfSheets = Excel::toCollection(new $importClass($this->payload), $this->getFile());
        $collectionOfSheets->each(function ($sheet) {
            $this->sheetHeader = $sheet->shift(); // remover header de csv
            $sheet->each(function ($row) {
                $this->processModel(collect($row));
            });
        });
        $this->import->failed_log = json_encode($this->failed);
        $this->import->processed_log = json_encode($this->processedModels);
        return $this;
    }

    public function getProcessedModels()
    {
        return $this->processedModels;
    }

    public function getFailedCsv()
    {
        $csv = Writer::createFromFileObject(new SplTempFileObject());
        $this->sheetHeader->push('Error');
        $csv->insertOne($this->sheetHeader->toArray());
        $csv->insertAll($this->failed->toArray());
        $csv->insertAll($this->processedRows->toArray());
        return $csv->toString();
    }

    public function processHasFails(): bool
    {
        return $this->getFailedRowCount() > 0;
    }

    public function getFailedRowCount(): int
    {
        return $this->failed->count();
    }

    protected function processModel(Collection $excelRow)
    {
        $validatorClass = $this->getValidatorRowClass();
        $rowWithPayload = $excelRow->merge(collect($this->payload));
        $excelRow = $excelRow->toArray();
        $validator = new $validatorClass($rowWithPayload->toArray());
        $validated = $validator->validate();
        if ($validated) {
            $this->processedModels->push($validator->getValidatedData());
            $this->processedRows->push($excelRow);
        } else {
            $excelRow['error'] = $validator->getErrorsAsString();
            $this->failed->push($excelRow);
        }
    }
}
