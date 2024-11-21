<?php

namespace App\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Form as LivewireForm;
use Livewire\Component;

class HumanForm extends LivewireForm
{
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
}

class Form extends Component
{
    public HumanForm $form;
    public $data = [];

    public function render()
    {
        return view('livewire.form', [
            'content' => markdown_convert(resource_path('docs/form.md'))
        ])
        ->title('Form');
    }

    function save()
    {
        $this->validate();
        // Add other hobby to hobbies
        array_push($this->form->hobbies, $this->form->otherHobby);
        $this->data = array_merge([], [
            'username' => $this->form->username,
            'email' => $this->form->email,
            'gender' => ucfirst($this->form->gender),
            'continent' => ucwords($this->form->continent),
            'dob' => \Carbon\Carbon::parse($this->form->dob)->locale('en_US')->isoFormat('MMMM DD YYYY'),
            'hobbies' => implode(', ', $this->form->hobbies),
            'bio' => $this->form->bio
        ]);
    }

    function clean()
    {
        // Clean the form
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
