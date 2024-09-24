<?php

namespace App\Livewire;

use App\Jobs\ProcessBikeShareFile;
use App\Jobs\ProcessCSVFile;
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
    private $table = 'websites';

    #[Computed]
    public function websites()
    {
        return DB::table($this->table)->paginate($this->perPage);
    }

    public function start()
    {
        $this->startBatch = true;

        DB::table($this->table)->truncate();

        $batch = Bus::batch([])->dispatch();

        $path = base_path('csvfile/majestic_million.csv');

        $handle = fopen($path, 'r');

        $header = fgetcsv($handle);

        $chunk = [];
        $chunkSize = 1000;

        while(($record = fgetcsv($handle)) !== false) {
            $chunk[] = $record;

            if (count($chunk) === $chunkSize) {
                $batch->add(new ProcessCSVFile($this->table, $header, $chunk));
                $chunk = [];
            }
        }

        if (!empty($chunk)) {
            $batch->add(new ProcessCSVFile($this->table, $header, $chunk));
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
