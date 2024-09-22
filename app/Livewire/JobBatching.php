<?php

namespace App\Livewire;

use App\Jobs\ProcessBikeShareFile;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class JobBatching extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $batchId;
    public $batchFinished, $batchCancelled = false;
    public $batchProgress = 0;
    public $startBatch = false;

    #[Computed]
    public function bikeShare()
    {
        return DB::table('bike_share')->paginate($this->perPage);
    }

    public function start()
    {
        $this->startBatch = true;

        DB::table('bike_share')->truncate();

        $batch = Bus::batch([])->dispatch();

        $path = base_path('csvfile/2010-capitalbikeshare-tripdata.csv');

        $handle = fopen($path, 'r');

        $header = fgetcsv($handle);
        $header = array_map(function ($head) {
            return implode('_', explode(' ', strtolower($head)));
        }, $header);

        $chunk = [];
        $chunkSize = 100;

        while(($record = fgetcsv($handle)) !== false) {
            $chunk[] = array_combine($header, $record);

            if (count($chunk) === $chunkSize) {
                $batch->add(new ProcessBikeShareFile($chunk));
                $chunk = [];
            }
        }

        if (!empty($chunk)) {
            $batch->add(new ProcessBikeShareFile($chunk));
        }

        $this->batchId = $batch->id;

        fclose($handle);
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

        if ($this->batchFinished) {
            $this->startBatch = false;
        }
    }

    public function render()
    {
        return view('livewire.job-batching')
        ->title('Job Batching');
    }
}
