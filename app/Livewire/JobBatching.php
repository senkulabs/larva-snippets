<?php

namespace App\Livewire;

use App\Jobs\ProcessInsertRecord;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class JobBatching extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $search = '';
    public $batchId;
    public $batchFinished, $batchCancelled = false;
    public $batchProgress = 0;
    public $startBatch = false;
    private $table = 'websites';

    public function updated($property)
    {
        if ($property === 'search') {
            $this->resetPage();
        }
    }

    #[Computed]
    public function websites()
    {
        $website = DB::table($this->table);

        if (!empty($this->search)) {
            $search = trim(strtolower($this->search));
            $website = $website->where('Domain', 'like', '%'.$search.'%');
        }

        $website = $website->orderBy('GlobalRank')->cursorPaginate($this->perPage);

        return $website;
    }

    public function start()
    {
        $this->startBatch = true;

        DB::table($this->table)->truncate();

        $websites = LazyCollection::make(function () {
            $handle = fopen(base_path('csvfile/majestic_million.csv'), 'r');

            $header = fgetcsv($handle);
            while (($line = fgetcsv($handle)) !== false) {
                yield array_combine($header, $line);
            }
        });

        $batch = Bus::batch([])->dispatch();
        $websites->chunk(1000)->each(function ($chunk) use ($batch) {
            $batch->add(new ProcessInsertRecord('websites', $chunk->toArray()));
        });

        $this->batchId = $batch->id;
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
        return view('livewire.job-batching', [
            'content' => markdown_convert(resource_path('docs/job-batching.md'))
        ])
        ->title('Job Batching');
    }
}
