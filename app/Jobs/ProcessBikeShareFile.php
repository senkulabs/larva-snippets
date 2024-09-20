<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ProcessBikeShareFile implements ShouldQueue
{
    use Batchable, Queueable;

    private $data;

    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // I use transaction to prevent error message from sqlite below.
        // Error message: General error: 5 database is locked.
        // The most reason is concurrent access: You're trying to write to the database at the same time,
        // this can cause locking issues.
        DB::transaction(function () {
            DB::table('bike_share')->insert($this->data);
        });
    }
}
