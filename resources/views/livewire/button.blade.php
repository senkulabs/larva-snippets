@push('styles')
<style>
    [x-cloak] {
        display: none !important;
    }
</style>
@endpush

<div x-data="{ count: 0, expanded: false, loading: $wire.entangle('loadingText').live }">
    <h2 x-text="count"></h2>

    <button x-on:click="count++">+</button>

    <br><br>

    <button type="button" x-on:click="expanded = !expanded">
        <span x-cloak x-show="!expanded">Show me!</span>
        <span x-cloak x-show="expanded">Hide me!</span>
    </button>

    <div x-cloak x-show="expanded">I'm scared!</div>

    <br><br>

    <button x-on:click="loading = true; $wire.click();" wire:loading.attr="disabled">Loading text</button>

    <p x-cloak x-show="loading">Loading...</p>
</div>