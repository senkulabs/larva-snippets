<?php

use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new
#[Title('Single Select - Larva Snippets')]
class extends Component {

    public $selectedOption = '1';

    public function with(): array
    {
        return [
            'md_content' => markdown_convert(resource_path('docs/single-select.md')),
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
}; ?>

@assets
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
<style>
    [x-cloak] {
        display: none !important;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
@endassets

<div>
    <a href="/" class="underline text-blue-500">Back</a>
    <h1 class="text-xl mb-4">Single Select with Tom Select</h1>

    {!! $md_content !!}
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
    <button class="border border-gray-300 p-2 rounded-lg cursor-pointer" wire:click="clearSelectedOption">Clear</button>
</div>
