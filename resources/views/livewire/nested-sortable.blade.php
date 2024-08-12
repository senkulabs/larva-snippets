@push('styles')
<style>
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
@endpush

@push('scripts')
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
    <form wire:submit.prevent="submit">
        <input type="text" wire:model="item" placeholder="Insert an item">
        <button type="submit">Submit</button>
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
