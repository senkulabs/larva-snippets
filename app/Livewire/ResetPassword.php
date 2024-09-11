<?php

namespace App\Livewire;

use App\Http\Requests\ResetPasswordRequest;
use Livewire\Component;

class ResetPassword extends Component
{
    public $password;
    public $password_confirmation;
    public $message;

    public function rules()
    {
        return (new ResetPasswordRequest())->rules();
    }

    public function clearForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->password = '';
        $this->password_confirmation = '';
    }

    public function submit()
    {
        $this->validate();

        $this->message = 'Reset password success!';
    }

    public function render()
    {
        return view('livewire.reset-password');
    }
}
