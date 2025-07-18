<?php

use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new
#[Title('Alert - Larva Snippets')]
class extends Component {
    public $visible = true;

    public function with(): array
    {
        return [
            'md_content' => markdown_convert(resource_path('docs/alert.md'))
        ];
    }

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
    <a href="/" class="underline text-blue-500">Back</a>
    <h1 class="text-xl mb-4">Alert with Sweet Alert</h1>
    {!! $md_content !!}
    @if ($visible)
        <div class="flex items-center gap-2 mb-4">
            <p>Delete me and I will say good bye!</p>
            <button onclick="confirmDestroy(this);" data-message="Are you sure to delete this item?" class="bg-red-500 p-1 rounded text-white">Delete</button>
        </div>
    @else
        <p class="mb-4">Good bye! 👋🏼</p>
    @endif
</div>
