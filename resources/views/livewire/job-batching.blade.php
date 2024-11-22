<?php

namespace App\Livewire;

use App\Jobs\ProcessInsertRecord;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new
#[Title('Job Batching - Larva Interactions')]
class extends Component
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

    public function with(): array
    {
        return [
            'md_content' => markdown_convert(resource_path('docs/job-batching.md'))
        ];
    }
}
?>

<div x-data="{ batchFinished: $wire.entangle('batchFinished').live,
        batchCancelled: $wire.entangle('batchCancelled').live,
        batchProgress: $wire.entangle('batchProgress').live,
        startBatch: $wire.entangle('startBatch').live,
     }" x-effect="console.log('batch finished: ', batchFinished, 'batch cancelled: ', batchCancelled, 'batch progress: ', batchProgress, 'start batch: ', startBatch)"
    x-init="$watch('batchFinished', (value) => {
        if (value) {
            startBatch = false;
        }
     });">

    <a href="/" class="underline text-blue-500">Back</a>

    <h1 class="text-2xl">Job Batching</h1>
    {!! $md_content !!}
    <p>This example shows how to implements Job Batching with Livewire and Alpine using <a class="underline text-blue-500" href="https://blog.majestic.com/development/majestic-million-csv-daily/">Majestic Million data.</a></p>
    <p>The CSV file stored in <code class="bg-gray-100 p-1 inline-block rounded">csvfile</code> directory.</p>

    <div class="my-4">
        <button type="button" @click="startBatch = true; batchFinished = false; batchCancelled = false; batchProgress = 0; $wire.start();" :disabled="startBatch" :class="startBatch ? 'disabled:bg-slate-100' : ''" class="bg-blue-300 p-2 rounded">Import</button>

        <template x-if="startBatch && !batchFinished">
            <div class="relative pt-1" wire:key="batch-start" wire:poll="updateBatchProgress">
                <div class="overflow-hidden h-4 flex rounded bg-green-100">
                    <div :style="{width: batchProgress + '%'}" class="bg-green-500 transition-all"></div>
                </div>
                <div class="flex justify-end" x-text="batchProgress + '%'"></div>
            </div>
        </template>

        <template x-if="batchFinished">
            <div class="relative pt-1" wire:key="batch-end">
                <div class="overflow-hidden h-4 flex rounded bg-green-100">
                    <div :style="{width: '100%'}" class="bg-green-500 transition-all"></div>
                </div>
                <div class="flex justify-end" x-text="'100%'"></div>
            </div>
        </template>

        <template x-if="batchCancelled && !batchFinished">
            <div class="mt-4 flex justify-end">
                <p class="text-red-600">Failed!</p>
            </div>
        </template>
    </div>

    <div class="flex items-center gap-4 my-4">
        <div class="flex-1">
            <label>
                <select wire:model.change="perPage">
                    <option>10</option>
                    <option>25</option>
                    <option>50</option>
                    <option>100</option>
                </select>
                entries per page
            </label>
            <input type="text" wire:model.change="search">
        </div>

        <button wire:click="$refresh" class="rounded p-2 bg-blue-500 text-white">Refresh</button>
    </div>

    <table class="w-full table-auto border-collapse border border-slate-400">
        <thead>
            <tr>
                <th class="p-2 border border-slate-300">GlobalRank</th>
                <th class="p-2 border border-slate-300">Domain</th>
                <th class="p-2 border border-slate-300">TLD</th>
                <th class="p-2 border border-slate-300">RefSubNets</th>
                <th class="p-2 border border-slate-300">RefIPs</th>
                <th class="p-2 border border-slate-300">PrevGlobalRank</th>
                <th class="border border-slate-300">PrevRefSubNets</th>
                <th class="border border-slate-300">PrevRefIPs</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($this->websites as $site)
            <tr @class(['bg-gray-100'=> ($loop->index % 2 === 0)])>
                <td class="p-2 border border-slate-300">{{ $site->GlobalRank }}</td>
                <td class="p-2 border border-slate-300">{{ $site->Domain }}</td>
                <td class="p-2 border border-slate-300">{{ $site->TLD }}</td>
                <td class="p-2 border border-slate-300">{{ $site->RefSubNets }}</td>
                <td class="p-2 border border-slate-300">{{ $site->RefIPs }}</td>
                <td class="p-2 border border-slate-300">{{ $site->PrevGlobalRank }}</td>
                <td class="p-2 border border-slate-300">{{ $site->PrevRefSubNets }}</td>
                <td class="p-2 border border-slate-300">{{ $site->PrevRefIPs }}</td>
            </tr>
            @empty
            <tr>
                <td class="p-2 text-center bg-gray-100" colspan="12">No data.</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="12">{{ $this->websites->links() }}</td>
            </tr>
        </tfoot>
    </table>
</div>
