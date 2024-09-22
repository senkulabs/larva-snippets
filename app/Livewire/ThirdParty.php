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
    public $content;

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

    public function submit()
    {
        // May be add some validation here!
    }

    public function render()
    {
        return view('livewire.third-party')
        ->title('Third Party');
    }
}
