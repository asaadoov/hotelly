@extends('layouts.app')

@section('content')
<div class="col">
<form id="form">
	@method('PUT')
    @include('bookings.fields')

    <div class="form-group row">
        <div class="col-sm-3">
            <button type="submit" class="btn btn-primary">Update Reservation</button>
        </div>
        <div class="col-sm-9">
            <a href="{{ route('bookings') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </div>
</form>
</div>
@endsection


@push('js')
<script>
$("#form").on('submit', function(e) {
    e.preventDefault();
    var form = $(this);

    $.ajax({
        url: '{{ route("booking.update", $booking) }}',
        method: 'POST',
        type: 'PUT',
        data: new FormData(form[0]),
        dataType: 'json',
        async: true,
        contentType: false,
        processData: false,
        success: function(data) {
            if(data.status == 'success') {
                Swal.fire({
                    title: data.title,
                    text: data.message,
                    type: data.status,
                    showCancelButton: false,
                    closeOnConfirm: true,
                }).then((confirm) => {
                    if(confirm.value) {
                        form.trigger('reset');
                        $('#modal').modal('hide');
                        window.location.href = "{{route('booking.show', $booking)}}";
                    }
                });
            }
            else {
                Swal.fire(data.title, data.message, data.status);
            }
        },
        error: function() {
            Swal.fire('Unexpected Error', 'The data cannot be sent. Please check your input.', 'error');
        }
    });
});
</script>
@endpush