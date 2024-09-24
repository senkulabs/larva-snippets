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

    <p>This example shows how to implements Job Batching with Livewire and AlpineJS using <a class="underline text-blue-500" href="https://blog.majestic.com/development/majestic-million-csv-daily/">Majestic Million data.</a></p>
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
                <th class="p-2 border border-slate-300">TldRank</th>
                <th class="p-2 border border-slate-300">Domain</th>
                <th class="p-2 border border-slate-300">TLD</th>
                <th class="p-2 border border-slate-300">RefSubNets</th>
                <th class="p-2 border border-slate-300">RefIPs</th>
                <th class="p-2 border border-slate-300">IDN_Domain</th>
                <th class="p-2 border border-slate-300">IDN_TLD</th>
                <th class="p-2 border border-slate-300">PrevGlobalRank</th>
                <th class="p-2 border border-slate-300">PrevTldRank</th>
                <th class="border border-slate-300">PrevRefSubNets</th>
                <th class="border border-slate-300">PrevRefIPs</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($this->websites as $site)
            <tr @class(['bg-gray-100'=> ($loop->index % 2 === 0)])>
                <td class="p-2 border border-slate-300">{{ $site->GlobalRank }}</td>
                <td class="p-2 border border-slate-300">{{ $site->TldRank }}</td>
                <td class="p-2 border border-slate-300">{{ $site->Domain }}</td>
                <td class="p-2 border border-slate-300">{{ $site->TLD }}</td>
                <td class="p-2 border border-slate-300">{{ $site->RefSubNets }}</td>
                <td class="p-2 border border-slate-300">{{ $site->RefIPs }}</td>
                <td class="p-2 border border-slate-300">{{ $site->IDN_Domain }}</td>
                <td class="p-2 border border-slate-300">{{ $site->IDN_TLD }}</td>
                <td class="p-2 border border-slate-300">{{ $site->PrevGlobalRank }}</td>
                <td class="p-2 border border-slate-300">{{ $site->PrevTldRank }}</td>
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
