<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ProcessCSVFile implements ShouldQueue
{
    use Batchable, Queueable;

    private $table;
    private $header;
    private $data;

    /**
     * Create a new job instance.
     */
    public function __construct($table, $header, $data)
    {
        $this->table = $table;
        $this->header = $header;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->data as $data) {
            DB::transaction(function () use ($data) {
                DB::table($this->table)->insert(array_combine($this->header, $data));
            });
        }
    }
}
