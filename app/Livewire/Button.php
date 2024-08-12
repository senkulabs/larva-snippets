<?php

namespace App\Livewire;

use Livewire\Component;

class Button extends Component
{
    public $loadingText = false;

    function click() 
    {
        sleep(2);
        $this->loadingText = false;
    }

    public function render()
    {
        return view('livewire.button');
    }
}
