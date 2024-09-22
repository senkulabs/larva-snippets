<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class NestedSortable extends Component
{
    public $data = '';
    public $item = '';

    #[On('set-data')]
    function setData($data)
    {
        $this->data = $data;
    }

    function submit()
    {
        if (!empty($this->item)) {
            $this->dispatch('nested-sortable-store-item', data: [
                'item' => $this->item
            ]);
            $this->item = '';
        }
    }

    public function render()
    {
        return view('livewire.nested-sortable')
        ->title('Nested Sortable');
    }
}
