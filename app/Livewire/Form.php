<?php

namespace App\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Component;

class Form extends Component
{
    public $data = [];
    #[Validate('required')]
    public $username = '';
    #[Validate('required|email')]
    public $email = '';
    #[Validate('required|confirmed|min:8')]
    public $password = '';
    public $password_confirmation = '';
    #[Validate('required')]
    public $gender = '';
    #[Validate('required')]
    public $hobbies = [];
    public $otherHobby = '';
    #[Validate('required')]
    public $continent = '';
    #[Validate('required')]
    public $bio = '';
    #[Validate('required')]
    public $dob = '';

    public function render()
    {
        return view('livewire.form');
    }

    function save()
    {
        $this->validate();
        // Add other hobby to hobbies
        array_push($this->hobbies, $this->otherHobby);
        $this->data = array_merge([], [
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'gender' => ucfirst($this->gender),
            'continent' => ucwords($this->continent),
            'dob' => \Carbon\Carbon::parse($this->dob)->locale('en_US')->isoFormat('MMMM DD YYYY'),
            'hobbies' => implode(', ', $this->hobbies),
            'bio' => $this->bio
        ]);
    }

    function clean()
    {
        // Clean the form
        $this->reset();
    }
}
