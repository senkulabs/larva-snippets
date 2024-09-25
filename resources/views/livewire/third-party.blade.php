@push('styles')
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
<style>
    [x-cloak] {
        display: none !important;
    }

    /* Nested sortable style */
    ul {
        list-style-type: none;
        margin: 0;
    }

    .list-group-item {
        border: 1px solid rgba(0, 0, 0, .125);
        padding: .5rem;
        cursor: move;
    }

    .list-group-item:last-child {
        border-bottom-left-radius: .25rem;
        border-bottom-right-radius: .25rem;
    }

    .list-group-item:hover {
        z-index: 0;
    }

    .nested-sortable,
    .nested-1,
    .nested-2,
    .nested-3 {
        margin-top: 5px;
    }

    .nested-1 {
        background-color: #e6e6e6;
    }

    .nested-2 {
        background-color: #cccccc;
    }

    .nested-3 {
        background-color: #b3b3b3;
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
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    let nestedSortables = Array.from(document.querySelectorAll('.nested-sortable'));
    for (let i = 0; i < nestedSortables.length; i++) {
        new Sortable(nestedSortables[i], {
            group: 'nested',
            animation: 150,
            fallbackOnBody: true,
            swapThreshold: 0.65,
            onEnd: function (evt) {
                let newData = JSON.stringify(serialize(root));
                console.log(newData);
                Livewire.dispatch('set-data', { data: newData });
            }
        });
    }

    const nestedQuery = '.nested-sortable';
    const identifier = 'id';
    const root = document.getElementById('wrapper-nested-sortable');
    function serialize(sortable) {
        const serialized = [];
        const children = [].slice.call(sortable.children);
        for (const i in children) {
            const nested = children[i].querySelector(nestedQuery);
            const parentId = children[i].closest(nestedQuery).getAttribute('data-parent-id');
            serialized.push({
                id: children[i].dataset[identifier],
                parent_id: parentId,
                children: nested ? serialize(nested) : [],
                order: (parseInt(i) + 1).toString(),
            });
        }
        return serialized;
    }

    window.addEventListener('nested-sortable-store-item', (e) => {
        document.getElementById('wrapper-nested-sortable').appendChild(
            document
            .createRange()
            .createContextualFragment(`<li data-id="${e.detail.data.item}" data-parent="0"
        class="list-group-item nested-1">${e.detail.data.item}
        </li>`));
    });
</script>
@endpush

<div>
    <a href="/" class="underline text-blue-500">Back</a>
    <h1 class="text-2xl mb-4">Third Party</h1>

    <h2 class="text-xl mb-4">Select with Tom Select</h2>
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

    <h2 class="text-xl mb-4">Alert with Sweet Alert</h2>
    @if ($visible)
        <div class="flex items-center gap-2 mb-4">
            <p>Delete me and I will say good bye!</p>
            <button onclick="confirmDestroy(this);" data-message="Are you sure to delete this item?" class="bg-red-500 p-1 rounded text-white">Delete</button>
        </div>
    @else
        <p class="mb-4">Good bye! 👋🏼</p>
    @endif

    <h2 class="text-xl mb-4">Text Area with Trix Editor</h2>
    <form class="mb-4" wire:submit="submitEditor">
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
            x-on:trix-file-accept="event.preventDefault()"
            x-on:trix-attachment-add="upload"
            x-on:trix-change="setValue"
            x-ref="trix"
            input="x" class="trix-content"></trix-editor>
        </div>
        <button class="bg-blue-500 text-white p-2 rounded my-4">Submit</button>
        {!! $content !!}
    </form>

    <h2 class="text-xl mb-4">Nested Sortable</h2>
    <p class="mb-4">Usually, I use nested sortable to display tree menu then drag and drop menu position. Imagine you build dynamic menus for your site.</p>
    <form class="flex gap-2" wire:submit.prevent="submitSortable">
        <input type="text" wire:model="sortableItem" placeholder="Insert an item" class="flex-1 rounded">
        <button type="submit" class="bg-blue-500 p-2 rounded text-white">Submit</button>
    </form>
    <div wire:ignore>
        {!! build_sortable_list(get_menus()) !!}
    </div>
    @if (!empty($data))
    <pre style="overflow-x: scroll;">
        <code>
            {{ @json_encode($data) }}
        </code>
    </pre>
    @else
    <p>Please drag and drop the list above to see updated list.</p>
    @endif
</div>
