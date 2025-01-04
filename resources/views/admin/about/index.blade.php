@extends('layouts.admin')

@section('content')
	<!--Container-->
	<div class="container w-full md:w-4/5 xl:w-3/5 mx-auto px-2">
		<!--Title-->
		<h1 class="flex items-center font-sans font-bold break-normal text-indigo-500 px-2 py-8 text-xl md:text-2xl">
			Responsive <a class="underline mx-2" href="https://datatables.net/">DataTables.net</a> Table
		</h1>

		<!-- Create Button -->
		<a href="{{ route('abouts.create') }}" class="btn btn-success mb-4">Create New About</a>

		<!--Card-->
		<div id='recipients' class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">
			<table id="example" class="stripe hover" style="width:100%; padding-top: 1em; padding-bottom: 1em;">
				<thead>
					<tr>
						<th data-priority="1">Tittle</th>
						<th data-priority="2">Deskripsi</th>
						<th data-priority="3">Image</th>
						<th data-priority="4">Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach($abouts as $about)
					<tr>
						<td>{{ $about->tittle }}</td>
						<td>{{ $about->deskripsi }}</td>
						<td><img src="{{ asset('storage/' . $about->image) }}" alt="{{ $about->tittle }}" width="100"></td>
						<td>
							<a href="{{ route('abouts.edit', $about->id) }}" class="btn btn-primary">Edit</a>
							<form action="{{ route('abouts.destroy', $about->id) }}" method="POST" style="display:inline;">
								@csrf
								@method('DELETE')
								<button type="submit" class="btn btn-danger">Delete</button>
							</form>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<!--/Card-->
	</div>
	<!--/container-->

	<!-- jQuery -->
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

	<!--Datatables -->
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
	<script>
		$(document).ready(function() {
			var table = $('#example').DataTable({
					responsive: true
				})
				.columns.adjust()
				.responsive.recalc();
		});
	</script>
@endsection
