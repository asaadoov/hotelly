@extends('layouts.app')
@include('plugins.datatable')

@section('content')
<div class="container-fluid">
<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Rooms</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>#</th>
							<th>Number</th>
							<th>Type</th>
						</tr>
					</thead>
					<tbody>
						@foreach($rooms as $room)
						<tr>
							<td>{{$room->id}}</td>
							<td>{{$room->number}}</td>
							<td>{{$room->roomType->name}}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>

</div>
@endsection