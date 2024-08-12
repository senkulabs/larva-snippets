@push('styles')
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
<style>
    [x-cloak] {
        display: none !important;
    }
</style>
@endpush
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
@endpush

<div>
    <h1>Select plugin with Tom Select</h1>
    <h2>Single option</h2>
    <div wire:ignore>
        <select x-data="{
            tomSelectInstance: null,
            options: {{ collect($options) }},
            items: $wire.entangle('selectedOption').live
        }"
        x-init="tomSelectInstance = new TomSelect($refs.select, {
            valueField: 'id',
            labelField: 'name',
            searchField: 'name',
            options: options,
            items: items,
            onItemAdd: function () {
                this.setTextboxValue('');
            }
        }); $watch('items', (value, oldValue) => {
            const result = JSON.parse(JSON.stringify(value));
            if (result.length === 0) {
                tomSelectInstance.clear();
            }
        });"
        x-ref="select"
        x-cloak
        id="selectedOption"
        wire:model.live="selectedOption"
        autocomplete="off">

        </select>
    </div>
    <p>Selected option: {{ @json_encode($selectedOption) }}</p>

    <h2>Multiple options</h2>
    <div wire:ignore>
        <select x-data="{
            tomSelectInstance: null,
            options: {{ collect($options) }},
            items: $wire.entangle('selectedOptions').live
        }"
        x-init="tomSelectInstance = new TomSelect($refs.select, {
            valueField: 'id',
            labelField: 'name',
            searchField: 'name',
            options: options,
            items: items,
            maxItems: 2,
            onItemAdd: function () {
                this.setTextboxValue('');
                this.refreshOptions();
            }
        }); $watch('items', (value, oldValue) => {
            const result = JSON.parse(JSON.stringify(value));
            if (result.length === 0) {
                tomSelectInstance.clear();
            }
        })"
        x-ref="select"
        x-cloak
        id="selectedOptions"
        wire:model.live="selectedOptions"
        multiple
        autocomplete="off">

        </select>
    </div>
    <p>Selected options: {{ @json_encode($selectedOptions) }}</p>
</div>
