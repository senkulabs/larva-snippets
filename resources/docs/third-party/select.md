<details class="my-4">
    <summary>Let me see the code 👀</summary>
    
```php tab=Route filename=routes/web.php
<?php

Route::get('/third-party', function () {
    return view('third-party');
});
```

```html tab=View filename=resources/views/third-party.blade.php
<x-app-layout>
    <x-slot name="title">Third Party - Larva Interactions</x-slot>
    <a href="/" class="underline text-blue-500">Back</a>
    <h1 class="text-2xl mb-4">Third Party</h1>
    <livewire:third-party.alert /> 
    <livewire:third-party.select/> <!-- [tl! add] -->
    <livewire:third-party.text-editor/>
    <livewire:third-party.nested/>
</x-app-layout>
```

```php tab=Volt filename=resources/views/livewire/third-party/nested.blade.php
<?php

use Livewire\Volt\Component;

new class extends Component {

    public $selectedOption = '1';
    public $selectedOptions = ['3', '4'];

    public function with(): array
    {
        return [
            'md_content' => markdown_convert(resource_path('docs/third-party/select.md')),
            'options' => [
                [
                    'id' => '1',
                    'name' => 'Jujutsu Kaisen'
                ],
                [
                    'id' => '2',
                    'name' => 'One Piece'
                ],
                [
                    'id' => '3',
                    'name' => 'Elusive Samurai'
                ],
                [
                    'id' => '4',
                    'name' => 'Black Clover'
                ]
            ]
        ];
    }

    function clearSelectedOption()
    {
        $this->selectedOption = '';
    }

    function clearSelectedOptions()
    {
        $this->selectedOptions = [];
    }
}; ?>

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
    <h2 class="text-xl mb-4">Select with Tom Select</h2>
    {!! $md_content !!}
    <h3 class="text-lg">Single option</h3>
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
    <p class="mb-4">Selected option: {{ @json_encode($selectedOption) }}</p>

    <h3 class="text-lg">Multiple options</h3>
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
    <p class="mb-4">Selected options: {{ @json_encode($selectedOptions) }}</p>
</div>
```
</details>
