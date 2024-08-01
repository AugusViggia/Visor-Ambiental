<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use League\Csv\Reader;
use League\Csv\Statement;

class CsvSeeder extends Seeder
{
    protected $filePath = '';
    protected $delimiter = ',';
    protected $headerOffset = 0;
    protected $model;
    protected $startInfo = 'Creando %s ...';
    protected $endInfo = '%s seeder finalizado!';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->process();
    }

    protected function process($mapperCallback = null)
    {
        $reader = Reader::createFromPath(base_path(). $this->filePath);
        $reader->setDelimiter($this->delimiter);
        $reader->setHeaderOffset($this->headerOffset);

        $data = (new Statement())->process($reader);

        $this->model = new $this->model;

        $className = (new \ReflectionClass($this->model))->getShortName();

        $this->command->info(sprintf($this->startInfo, $className));

        $this->command->getOutput()->progressStart(count($data));

        $this->makeInserts($data, $mapperCallback);

        $this->command->line('');
        $this->command->info(sprintf($this->endInfo, $className));
    }

    protected function makeInserts($data, $mapperCallback)
    {
        foreach ($data as $value) {
            if (is_callable($mapperCallback)) {
                $value = call_user_func($mapperCallback, $value);
            }

            if ($value) {
                $this->model->create($value);
            }

            $this->command->getOutput()->progressAdvance();
        }
    }
}
