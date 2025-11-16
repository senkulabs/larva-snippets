<?php

use Livewire\Attributes\Title;
use Livewire\Form as LivewireForm;
use Livewire\Volt\Component;

class BookingForm extends LivewireForm
{
    public $name = '';
    public $email = '';
    public $services = [];
    public $otherService = '';
    public $roomType = 'standard';
    public $country = '';
    public $checkIn = '';
    public $checkOut = '';

    public function rules()
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'services' => 'required',
            'country' => 'required',
        ];

        if (in_array('other', $this->services)) {
            $rules['otherService'] = 'required';
        }

        return $rules;
    }

    public function store()
    {
        $key = array_search('other', $this->services);
        if ($key !== false) {
            unset($this->services[$key]);
            array_push($this->services, $this->otherService);
        }

        $result = array_merge([], [
            'name' => $this->name,
            'email' => $this->email,
            'services' => implode(', ', $this->services),
            'roomType' => $this->roomType,
            'country' => $this->country,
        ]);

        return $result;
    }
}

new
#[Title('Booking Form - Larva Snippets')]
class extends Component
{
    public BookingForm $form;
    public $data = [];

    public function with(): array
    {
        return [
            'content' => '',
        ];
    }

    function save()
    {
        $this->validate();
        $this->data = $this->form->store();
        $this->resetExcept(['data']);
    }
}
?>

<div>
    <a href="/" class="underline text-blue-500">Back</a>
    <h1 class="text-2xl mb-4">Booking Form</h1>
    <p class="mb-4">The root cause of why programmers do CRUD (Create, Read, Update, and Delete)</p>
    {!! $content !!}
    <form wire:submit="save">
        <div class="mb-4">
            <label for="name" class="block">Name</label>
            <input id="name" type="text" wire:model="form.name" placeholder="Alice Merton" class="block w-full lg:w-3/4 rounded-md">
            @error('form.name') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label for="email" class="block">Email</label>
            <input id="email" type="email" wire:model="form.email" placeholder="alice@mail.com" class="block w-full lg:w-3/4 rounded-md">
            @error('form.email') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <fieldset class="block space-x-2">
                <legend>Room Type</legend>
                <label class="flex items-center gap-2">
                    <input type="radio" value="standard" wire:model="form.roomType"> Standard Room
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" value="superior" wire:model="form.roomType"> Superior Room
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" value="deluxe" wire:model="form.roomType"> Deluxe Room
                </label>
            </fieldset>
            @error('form.roomType') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <fieldset class="block space-y-2">
                <legend>Services</legend>
                <label class="block">
                    <input type="checkbox" value="breakfast" wire:model="form.services"> Breakfast Included
                </label>
                <label class="block">
                    <input type="checkbox" value="airport" wire:model="form.services"> Airport Pickup
                </label>
                <label class="block">
                    <input type="checkbox" value="early check-in" wire:model="form.services"> Early check-in
                </label>
                <label class="block">
                    <input type="checkbox" value="late checkout" wire:model="form.services"> Late checkout
                </label>
                <label class="block">
                    <input type="checkbox" value="daily room cleaning" wire:model="form.services"> Daily room cleaning
                </label>
                <label class="block">
                    <input type="checkbox" value="other" wire:model="form.services">
                    <input type="text" wire:model="form.otherService" placeholder="Describe other services..." class="rounded-md">
                </label>
                @error('form.servies') <span class="text-red-500">{{ $message }}</span> @enderror
                @error('form.otherService') <span class="text-red-500">{{ $message }}</span> @enderror
            </fieldset>
        </div>
        <div class="mb-4">
            <label for="country" class="block">Country</label>
            <select wire:model="form.country" class="block w-full lg:w-3/4 rounded-md">
                <option value="">Country</option>
                <option value="AUS">Australia</option>
                <option value="CHE">Switzerland</option>
                <option value="CHN">China</option>
                <option value="DEU">Germany</option>
                <option value="EST">Estonia</option>
                <option value="FRA">France</option>
                <option value="GBR">United Kingdom</option>
                <option value="HKG">Hong Kong S.A.R</option>
                <option value="JPN">Japan</option>
                <option value="KOR">South Korea</option>
                <option value="SWE">Sweden</option>
                <option value="USA">United States</option>
            </select>
            @error('form.country') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>
        <button class="bg-black py-2 px-6 rounded-md text-white cursor-pointer">Submit</button>
    </form>

    @if (!empty($data))
    <pre style="overflow-x: scroll;">
        <code>
            {{ @json_encode($data) }}
        </code>
    </pre>
    @else
        <p class="my-4">No data available.</p>
    @endif
</div>
