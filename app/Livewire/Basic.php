<?php

namespace App\Livewire;

use Livewire\Component;

class Basic extends Component
{
    public $loading = false;

    function click()
    {
        sleep(2);
        $this->loading = false;
    }

    public function render()
    {
        return view('livewire.basic');
    }
}
