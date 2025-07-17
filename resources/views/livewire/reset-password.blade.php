<?php

use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new
#[Title('Reset Password - Larva Snippets')]
class extends Component {
    public $password = '';
    public $password_confirmation = '';

    public function rules()
    {
        return [
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->letters()->numbers()],
        ];
    }

    public function messages()
    {
        return [
            'password.mixed' => 'Password should have uppercase, lowercase, and number.',
        ];
    }

    function submit()
    {
        $this->validate();
        $this->reset();
    }
}; ?>

<div>
    <a href="/" class="underline text-blue-500">Back</a>
    <h1 class="text-2xl mb-4">Reset Password</h1>
    <form wire:submit="submit" x-data="{ showPassword: false, showPasswordConfirmation: false }">
        <div class="flex flex-col space-y-4 md:grid md:grid-cols-2 md:gap-4">
            <div class="mb-4">
                <label for="password" class="block @error('password') text-red-500 @enderror">Password</label>
                <div class="relative">
                    <input :type="showPassword ? 'text' : 'password'" wire:model="password" class="block w-full rounded @error('password') border-red-500 @enderror">
                    <button type="button" class="absolute inset-y-0 right-0 px-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-500 border border-transparent rounded-r-md active:bg-blue-500 hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-400" @click="showPassword = !showPassword" :class="{ 'hidden': showPassword, 'block': !showPassword }">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>
                    <button type="button" class="absolute inset-y-0 right-0 px-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-500 border border-transparent rounded-r-md active:bg-blue-500 hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-400" @click="showPassword = !showPassword" :class="{ 'hidden': !showPassword, 'block': showPassword }">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </button>
                </div>
                @error('password') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label for="password-confirmation" class="block @error('password') text-red-500 @enderror">Password Confirmation</label>
                <div class="relative">
                    <input id="password-confirmation" :type="showPasswordConfirmation ? 'text' : 'password'" wire:model="password_confirmation" class="block w-full rounded @error('password') border-red-500 @enderror">
                    <button type="button" class="absolute inset-y-0 right-0 px-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-500 border border-transparent rounded-r-md active:bg-blue-500 hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-400" @click="showPasswordConfirmation = !showPasswordConfirmation" :class="{ 'hidden': showPasswordConfirmation, 'block': !showPasswordConfirmation }">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>
                    <button type="button" class="absolute inset-y-0 right-0 px-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-500 border border-transparent rounded-r-md active:bg-blue-500 hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-400" @click="showPasswordConfirmation = !showPasswordConfirmation" :class="{ 'hidden': !showPasswordConfirmation, 'block': showPasswordConfirmation }">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </button>
                </div>
                @error('password') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>
        <button class="bg-blue-500 p-2 rounded text-white" wire:loading.attr="disabled">
            <svg version="1.1" class="h-5 w-5" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve" wire:loading wire:target="submit">
                <path fill="#fff" d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                    <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s" from="0 50 50" to="360 50 50" repeatCount="indefinite" />
                </path>
            </svg>
            Reset
        </button>
    </form>
</div>
