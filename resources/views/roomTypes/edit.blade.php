@extends('layouts.app')
@include('plugins.dropify')


@section('content')
<div class="col">
<form action="{{ route('roomType.update', $roomType)}}" method="POST" id="form" enctype="multipart/form-data">
    @method('PUT')

    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="name">Name</label>
        <div class="col-sm-12">
            <input name="name" type="text" class="form-control" required value="{{ $roomType->name ?? '' }}"/>
            <small class="form-text text-muted">The room type name.</small>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="description">Description</label>
        <div class="col-sm-12">
            <input name="description" type="text" class="form-control" required value="{{ $roomType->description ?? '' }}"/>
            <small class="form-text text-muted">The room type description.</small>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-12">
            <div class="form-group mt-2 mb-3" id="test">
                <input type="file" id="image" required name="image" class="dropify">
            </div>
        </div>
    </div>

    @csrf


    <div class="form-group row ">
        <div class="col-sm-8 ">
            <button type="submit" class="btn btn-primary">Update Room</button>
            <a href="" class="btn btn-secondary">Cancel</a>
        </div>
    </div>
</form>
</div>
@endsection

@push('js')
<script type="text/javascript">
    $(document).ready(function(){
        $('#dropify');
    });
    $("#form").on('submit', function (e) {
        e.preventDefault();
        var form = $(this);

        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
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
                            $('.dropify-clear').click();
                            window.location.href = "{{route('room_types', $roomType)}}";

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