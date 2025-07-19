<?php

use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new
#[Title('Nested Sortable - Larva Snippets')]
class extends Component {
    public $sortableData;
    public $sortableItem;

    public function with(): array
    {
        return [
            'md_content' => markdown_convert(resource_path('docs/nested-sortable.md')),
        ];
    }

    #[On('set-data')]
    function setSortableData($data)
    {
        $this->sortableData = $data;
    }

    public function submitSortable()
    {
        if (!empty($this->sortableItem)) {
            $this->dispatch('nested-sortable-store-item', data: [
                'item' => $this->sortableItem
            ]);
            $this->sortableItem = '';
        }
    }
}; ?>

@assets
<style>
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
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
@endassets

@script
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
                $wire.dispatch('set-data', { data: newData });
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
@endscript

<div>
    <a href="/" class="underline text-blue-500">Back</a>
    <h1 class="text-xl mb-4">Nested Sortable</h1>
    <p class="mb-4">Usable for display tree menu then drag and drop menu position. Imagine you build dynamic menus for your site.</p>
    {!! $md_content !!}
    <form class="flex gap-2" wire:submit.prevent="submitSortable">
        <input type="text" wire:model="sortableItem" placeholder="Insert an item" class="flex-1 rounded">
        <button type="submit" class="bg-blue-500 p-2 rounded text-white">Submit</button>
    </form>
    <div wire:ignore>
        {!! build_sortable_list(get_menus()) !!}
    </div>
    @if (!empty($sortableData))
    <pre style="overflow-x: scroll;">
        <code>
            {{ @json_encode($sortableData) }}
        </code>
    </pre>
    @else
    <p>Please drag and drop the list above to see updated list.</p>
    @endif
</div>
