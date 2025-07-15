<details class="my-4">
    <summary>Let me see the code 👀</summary>
    
```php tab=Route filename=routes/web.php
<?php

Route::get('/third-party', function () {
    return view('third-party');
});
```

```html tab=View filename=resources/views/third-party.blade.php
<x-app-layout>
    <x-slot name="title">Third Party - Larva Snippets</x-slot>
    <a href="/" class="underline text-blue-500">Back</a>
    <h1 class="text-2xl mb-4">Third Party</h1>
    <livewire:third-party.alert /> <!-- [tl! add] -->
    <livewire:third-party.select/>
    <livewire:third-party.text-editor/>
    <livewire:third-party.nested/>
</x-app-layout>
```

```php tab=Volt filename=resources/views/livewire/third-party/alert.blade.php
<?php

use Livewire\Attributes\On;
use Livewire\Volt\Component;

new class extends Component {
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
}; ?>

@push('scripts')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js" crossorigin="anonymous"></script>
<script>
    function confirmDestroy(el) {
        swal({
            title: 'Warning!',
            text: el.getAttribute('data-message'),
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                swal('Data is being deleted. Please wait...', {
                    icon: 'info',
                    closeOnClickOutside: false,
                    button: false
                });
                window.Livewire.dispatch('destroy');
            } else {
                swal('Your data still saved!')
            }
        })
    }

    window.addEventListener('alert:ok', function (e) {
        swal({
            icon: 'success',
            text: e.detail.data.message
        });
    })
</script>
@endpush

<div>
    <h2 class="text-xl mb-4">Alert with Sweet Alert</h2>
    @if ($visible)
        <div class="flex items-center gap-2 mb-4">
            <p>Delete me and I will say good bye!</p>
            <button onclick="confirmDestroy(this);" data-message="Are you sure to delete this item?" class="bg-red-500 p-1 rounded text-white">Delete</button>
        </div>
    @else
        <p class="mb-4">Good bye! 👋🏼</p>
    @endif
</div>
```
</details>
