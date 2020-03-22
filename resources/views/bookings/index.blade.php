@extends('layouts.app')

@section('buttons')
<a class="btn btn-primary mb-3" href="{{ route('bookings.create') }}" role="button">Add New Booking</a>
@endsection

@section('content')
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Room</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Reservation?</th>
            <th>Paid?</th>
            <th>Started?</th>
            <th>Passed?</th>
            <th>Created</th>
            <th class="Actions">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($bookings as $booking)
            <tr>
                <td>{{ $booking->id }}</td>
                <td>{{ $booking->room->number}} {{ $booking->room->roomType->name}}</td>
                <td>{{ date('F d, Y', strtotime($booking->start)) }}</td>
                <td>{{ date('F d, Y', strtotime($booking->end)) }}</td>
                <td>{{ $booking->is_reservation ? 'Yes' : 'No' }}</td>
                <td>{{ $booking->is_paid ? 'Yes' : 'No' }}</td>
                <td>{{ (strtotime($booking->start) < time()) ? 'Yes' : 'No' }}</td>
                <td>{{ (strtotime($booking->end) < time()) ? 'Yes' : 'No' }}</td>
                <td>{{ date('F d, Y', strtotime($booking->created_at)) }}</td>
                <td class="actions">
                    <a
                        href="{{ route('booking.show', $booking->id) }}"
                        alt="View"
                        title="View">
                    View
                    </a> /
                    <a
                        href="{{ route('booking.edit', $booking->id) }}"
                        alt="Edit"
                        title="Edit">
                    Edit
                    </a> /
                    <button type="submit" onclick="remove({{$booking->id}})" class="btn btn-link" title="Delete" value="DELETE">
                        Delete
                    </button>
                    
                </td>
            </tr>
        @empty
        @endforelse
    </tbody>
</table>
{{ $bookings->links() }}
@endsection

@push('js')
<script>
function remove(booking){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    Swal.fire({
        title: "Confirm Remove?",
        text: "Any deleted data would not be recoverable. Proceed?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Remove',
        showLoaderOnConfirm: true,
        allowOutsideClick: () => !Swal.isLoading(),
    }).then((confirm) => {
        if(confirm.value) {
            $.ajax({
                url: '/bookings/'+booking,
                method: 'delete',
                dataType: 'json',
                async: true,
                contentType: false,
                processData: false,
                success: function(data) {
                    Swal.fire(data.title, data.message, data.status).then((confirm) => {
                        if(confirm.value) {location.reload();}
                    });
                    
                },
                error: function() {
                    Swal.fire('Unexpected Error', 'The data cannot be sent. Please check your input.', 'error');
                }
            });
        }
    });
}
</script>
@endpush
