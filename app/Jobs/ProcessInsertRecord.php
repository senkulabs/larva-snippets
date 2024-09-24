<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ProcessInsertRecord implements ShouldQueue
{
    use Batchable, Queueable;

    private $table;
    private $data;

    /**
     * Create a new job instance.
     */
    public function __construct($table, $data)
    {
        $this->table = $table;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::transaction(function () {
            DB::table($this->table)->insert($this->data);
        });
    }
}
