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
    <button type="button" @click="startBatch = true; batchFinished = false; batchProgress = 0; $wire.start();" :disabled="startBatch" :class="startBatch ? 'disabled:bg-slate-100' : ''" class="bg-blue-300 p-2 rounded">Start Job Batching</button>

    <template x-if="batchFinished">
        <div class="relative pt-1" wire:key="batch-end">
            <div class="overflow-hidden h-4 flex rounded bg-green-100">
                <div :style="{width: '100%'}" class="bg-green-500 transition-all"></div>
            </div>
            <div class="flex justify-end" x-text="'100%'"></div>
        </div>
    </template>

    <template x-if="startBatch && !batchFinished">
        <div class="relative pt-1" wire:key="batch-start" wire:poll="updateBatchProgress">
            <div class="overflow-hidden h-4 flex rounded bg-green-100">
                <div :style="{width: batchProgress + '%'}" class="bg-green-500 transition-all"></div>
            </div>
            <div class="flex justify-end" x-text="batchProgress + '%'"></div>
        </div>
    </template>

    <template x-if="batchCancelled && !batchFinished">
        <div class="mt-4 flex justify-end">
            <p class="text-red-600">Failed!</p>
        </div>
    </template>
</div>
