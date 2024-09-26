<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class ThirdParty extends Component
{
    public $options = [];
    public $selectedOption = '1';
    public $selectedOptions = ['3', '4'];
    public $visible = true;
    public $text;
    public $sortableData;
    public $sortableItem;

    public function mount()
    {
        $this->options = [
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

    #[On('destroy')]
    function destroy()
    {
        // Mock delete process in server with sleep function
        sleep(3);
        $this->dispatch('alert:ok', data: [
            'message' => 'Item has been deleted!'
        ]);
        $this->visible = false;
    }

    public function submitEditor()
    {
        // May be add some validation here!
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

    public function render()
    {
        return view('livewire.third-party', [
            'content' => markdown_convert(resource_path('docs/third-party.md'))
        ])
        ->title('Third Party');
    }
}
