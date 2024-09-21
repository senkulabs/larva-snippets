@push('styles')
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
<style>
    [x-cloak] {
        display: none !important;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/trix/dist/trix.min.css" crossorigin="anonymous">
@endpush
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js" crossorigin="anonymous"></script>
<script>
    function confirmDestroy(el) {
        swal({
            title: 'Warning!',
            text: el.getAttribute('data-message'),
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                swal('Data is being deleted. Please wait...', {
                    icon: 'info',
                    closeOnClickOutside: false,
                    button: false
                });
                window.Livewire.dispatch('destroy');
            } else {
                swal('Your data still saved!')
            }
        })
    }

    window.addEventListener('alert:ok', function (e) {
        swal({
            icon: 'success',
            text: e.detail.data.message
        });
    })
</script>
<script src="https://cdn.jsdelivr.net/npm/trix/dist/trix.umd.min.js" crossorigin="anonymous"></script>
@endpush

<div>
    <h1 class="text-2xl">Third Party</h1>

    <h2 class="text-xl">Select with Tom Select</h2>
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
    <p>Selected option: {{ @json_encode($selectedOption) }}</p>

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
    <p>Selected options: {{ @json_encode($selectedOptions) }}</p>

    <h2 class="text-xl">Alert with Sweet Alert</h2>
    @if ($visible)
        <p>If you confirm to delete action then I will disappear.</p>
        <button onclick="confirmDestroy(this);" data-message="Are you sure to delete this item?" class="bg-red-500 p-2 rounded text-white">Delete</button>
    @else
        <p>Good bye! 👋🏼</p>
    @endif

    <h2 class="text-xl">Text Area with Trix Editor</h2>
    <form wire:submit="submit">
        <input type="hidden" id="x">
        <div wire:ignore>
            <trix-editor x-data="{
                setValue(event) {
                    $wire.content = event.target.value;
                },
                upload(event) {
                    const data = new FormData();
                    data.append('file', event.attachment.file);

                    fetch('/upload-file', {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                        },
                        method: 'POST',
                        credentials: 'same-origin',
                        body: data
                    })
                    .then(response => response.json())
                    .then(data => {
                        event.attachment.setAttributes({
                            url: data.image_url
                        });
                    });
                }
            }"
            x-on:trix-attachment-add="upload"
            x-on:trix-change="setValue"
            x-ref="trix"
            input="x" class="trix-content"></trix-editor>
        </div>
        <button class="bg-blue-500 text-white p-2 rounded">Submit</button>
        {!! $content !!}
    </form>
</div>
