<?php

namespace App\Livewire;

use Livewire\Component;

class Select extends Component
{
    public $selectedOption = '1';
    public $selectedOptions = ['3', '4'];

    public function render()
    {
        return view('livewire.select', [
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
        ]);
    }

    function clearSelectedOption()
    {
        $this->selectedOption = '';
    }

    function clearSelectedOptions()
    {
        $this->selectedOptions = [];
    }
}
