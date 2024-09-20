<?php

namespace App\Livewire;

use App\Jobs\ProcessBikeShareFile;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;

class JobBatching extends Component
{
    public $batchId;
    public $batchFinished, $batchCancelled = false;
    public $batchProgress = 0;
    public $startBatch = false;

    public function start()
    {
        $this->startBatch = true;

        DB::table('bike_share')->truncate();

        $path = base_path('csvfile/2010-capitalbikeshare-tripdata.csv');

        $file = fopen($path, 'r');

        if ($file !== false) {
            $header = array_map(function ($head) {
                return implode('_', explode(' ', strtolower($head)));
            }, fgetcsv($file));
            $data = [];
            if ($header !== false) {
                while (($record = fgetcsv($file)) !== false) {
                    array_push($data, $record);
                }

                $batch = Bus::batch([])->dispatch();
                collect($data)->chunk(100)->each(function ($chunk) use ($header, $batch) {
                    $arrs = [];
                    foreach ($chunk as $item) {
                        $arr = array_combine($header, $item);
                        array_push($arrs, $arr);
                    }
                    $batch->add(new ProcessBikeShareFile($arrs));
                });


                $this->batchId = $batch->id;
            }
        }
    }

    #[Computed]
    public function batch()
    {
        if (!$this->batchId) {
            return null;
        }

        return Bus::findBatch($this->batchId);
    }

    public function updateBatchProgress()
    {
        $this->batchProgress = $this->batch->progress();
        $this->batchFinished = $this->batch->finished();
        $this->batchCancelled = $this->batch->cancelled();
    }

    public function render()
    {
        return view('livewire.job-batching');
    }
}
