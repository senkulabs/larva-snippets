<details class="my-4">
    <summary>Let me see the code 👀</summary>

```php tab=Route filename=routes/web.php
<?php

use Livewire\Volt\Volt;

Volt::route('/form', 'form');
```

```blade tab=Component filename=resources/views/livewire/form.blade.php
<?php

use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Form as LivewireForm;
use Livewire\Volt\Component;

class HumanForm extends LivewireForm
{
    #[Validate('required')]
    public $name = '';
    #[Validate('required|email')]
    public $email = '';
    #[Validate('required')]
    public $gender = '';
    #[Validate('required')]
    public $hobbies = [];
    public $otherHobby = '';
    #[Validate('required')]
    public $region = '';
    #[Validate('required')]
    public $bio = '';
    #[Validate('required')]
    public $dob = '';
}

new
#[Title('Form - Larva Snippets')]
class extends Component
{
    public HumanForm $form;
    public $data = [];

    public function with(): array
    {
        return [
            'content' => markdown_convert(resource_path('docs/form.md'))
        ];
    }

    function save()
    {
        $this->validate();
        // Add other hobby to hobbies
        array_push($this->form->hobbies, $this->form->otherHobby);
        $this->data = array_merge([], [
            'name' => $this->form->name,
            'email' => $this->form->email,
            'gender' => ucfirst($this->form->gender),
            'region' => $this->form->region,
            'dob' => \Carbon\Carbon::parse($this->form->dob)->locale('en_US')->isoFormat('MMMM DD YYYY'),
            'hobbies' => implode(', ', $this->form->hobbies),
            'bio' => $this->form->bio
        ]);
        $this->resetExcept(['data']);
    }
}
?>

<div>
    <a href="/" class="underline text-blue-500">Back</a>
    <h1 class="text-2xl mb-4">Form</h1>
    <p class="mb-4">The root cause of why programmers do CRUD (Create, Read, Update, and Delete)</p>
    {!! $content !!}
    <form wire:submit="save" x-data="{ showPassword: false, showPasswordConfirmation: false }">
        <div class="mb-4">
            <label for="name" class="block">Name</label>
            <input id="name" type="text" wire:model="form.name" placeholder="Name" class="block w-full rounded">
            @error('form.name') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label for="email" class="block">Email</label>
            <input id="email" type="email" wire:model="form.email" placeholder="Email" class="block w-full rounded">
            @error('form.email') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <fieldset class="block">
                <legend>Gender</legend>
                <label>
                    <input type="radio" value="male" wire:model="form.gender"> Male
                </label>
                <label>
                    <input type="radio" value="female" wire:model="form.gender"> Female
                </label>
            </fieldset>
            @error('form.gender') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <fieldset class="block">
                <legend>Hobbies</legend>
                <label class="block">
                    <input type="checkbox" value="walking" wire:model="form.hobbies"> Walking
                </label>
                <label class="block">
                    <input type="checkbox" value="cycling" wire:model="form.hobbies"> Cycling
                </label>
                <label class="block">
                    <input type="checkbox" value="weight training" wire:model="form.hobbies"> Weight Training
                </label>
                <label class="block">
                    <input type="checkbox" value="swimming" wire:model="form.hobbies"> Swimming
                </label>
                <label class="block">
                    <input type="checkbox" value="playing music" wire:model="form.hobbies"> Playing Music
                </label>
                <label class="block">
                    <input type="checkbox" value="sing a song" wire:model="form.hobbies"> Sing a Song
                </label>
                <label class="block">
                    <input type="checkbox" value="other" wire:model="form.hobbies"> Other
                </label>
                <div>
                    <label for="">
                        Please tell me your hobby
                        <input type="text" wire:model="form.otherHobby" placeholder="My hobby is" class="rounded">
                    </label>
                </div>
                @error('form.hobbies') <span class="text-red-500">{{ $message }}</span> @enderror
            </fieldset>
        </div>
        <div class="mb-4">
            <label for="region" class="block">Region</label>
            <select wire:model="form.region" class="block w-full rounded">
                <option value="">Region</option>
                <option value="asia">Asia</option>
                <option value="africa">Africa</option>
                <option value="north_america">North America</option>
                <option value="south_america">South America</option>
                <option value="antartic">Antartic</option>
                <option value="eropa">Eropa</option>
                <option value="australia">Australia</option>
            </select>
            @error('form.region') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label for="bio" class="block">Tell bit about your self</label>
            <textarea id="bio" wire:model="form.bio" cols="30" rows="10" class="block w-full rounded" placeholder="I am..."></textarea>
            @error('form.bio') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label for="dob" class="block">Date of Birth</label>
            <input id="dob" wire:model="form.dob" type="date" class="block w-full rounded">
            @error('form.dob') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>
        <button class="bg-blue-500 p-2 rounded text-white cursor-pointer">Submit</button>
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
```
</details>
