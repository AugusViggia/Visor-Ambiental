<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class ImportData implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $processedData;
    protected $importableService;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Collection $processedData, string $importClass)
    {
        $this->processedData = $processedData;
        $this->importableService = config('custom.imports.models_services.' . $importClass);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $service = app()->make($this->importableService);
        $service->import($this->processedData);
    }
}
