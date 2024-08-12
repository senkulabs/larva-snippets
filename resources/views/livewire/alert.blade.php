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
    <p>If you confirm to delete action then this button below will be disappear.</p>
    @if ($visible)
        <button onclick="confirmDestroy(this);" data-message="Are you sure to delete this item?">Delete</button>    
    @endif
</div>
