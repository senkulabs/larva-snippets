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

    <h1 class="text-2xl">Job Batching</h1>

    <p>This example shows how to implements Job Batching with Livewire and AlpineJS using <a class="underline text-blue-500" href="https://www.kaggle.com/datasets/alexsocarras/dc-capital-bikeshare">Capital Bike Share data.</a></p>
    <p>The CSV file stored in <code class="bg-gray-100 p-1 inline-block rounded">csvfile</code> directory.</p>

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

    <table class="border-collapse border border-slate-400">
        <thead>
            <tr>
                <th class="border border-slate-300">Duration</th>
                <th class="border border-slate-300">Start Date</th>
                <th class="border border-slate-300">End Date</th>
                <th class="border border-slate-300">Start Station Number</th>
                <th class="border border-slate-300">Start Station</th>
                <th class="border border-slate-300">End Station Number</th>
                <th class="border border-slate-300">End Station</th>
                <th class="border border-slate-300">Bike Number</th>
                <th class="border border-slate-300">Member Type</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($this->bike_share as $info)
            <tr>
                <td class="border border-slate-300">{{ $info->duration }}</td>
                <td class="border border-slate-300">{{ $info->start_date }}</td>
                <td class="border border-slate-300">{{ $info->end_date }}</td>
                <td class="border border-slate-300">{{ $info->start_station_number }}</td>
                <td class="border border-slate-300">{{ $info->start_station }}</td>
                <td class="border border-slate-300">{{ $info->end_station_number }}</td>
                <td class="border border-slate-300">{{ $info->end_station }}</td>
                <td class="border border-slate-300">{{ $info->bike_number }}</td>
                <td class="border border-slate-300">{{ $info->member_type }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9">No data.</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="9">{{ $this->bike_share->links() }}</td>
            </tr>
        </tfoot>
    </table>
</div>
