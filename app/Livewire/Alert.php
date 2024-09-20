<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class Alert extends Component
{
    public $visible = true;

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

    public function render()
    {
        return view('livewire.alert');
    }
}
