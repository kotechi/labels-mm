<!DOCTYPE html>
<html lang="en" class="antialiased">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>DataTables </title>
	<meta name="description" content="">
	<meta name="keywords" content="">
	<link href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" rel=" stylesheet">
	<!--Replace with your tailwind.css once created-->


	<!--Regular Datatables CSS-->
	<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
	<!--Responsive Extension Datatables CSS-->
	<link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">

	<style>
		/*Overrides for Tailwind CSS */

		/*Form fields*/
		.dataTables_wrapper select,
		.dataTables_wrapper .dataTables_filter input {
			color: #4a5568;
			/*text-gray-700*/
			padding-left: 1rem;
			/*pl-4*/
			padding-right: 1rem;
			/*pl-4*/
			padding-top: .5rem;
			/*pl-2*/
			padding-bottom: .5rem;
			/*pl-2*/
			line-height: 1.25;
			/*leading-tight*/
			border-width: 2px;
			/*border-2*/
			border-radius: .25rem;
			border-color: #edf2f7;
			/*border-gray-200*/
			background-color: #edf2f7;
			/*bg-gray-200*/
		}

		/*Row Hover*/
		table.dataTable.hover tbody tr:hover,
		table.dataTable.display tbody tr:hover {
			background-color: #ebf4ff;
			/*bg-indigo-100*/
		}

		/*Pagination Buttons*/
		.dataTables_wrapper .dataTables_paginate .paginate_button {
			font-weight: 700;
			/*font-bold*/
			border-radius: .25rem;
			/*rounded*/
			border: 1px solid transparent;
			/*border border-transparent*/
		}

		/*Pagination Buttons - Current selected */
		.dataTables_wrapper .dataTables_paginate .paginate_button.current {
			color: #fff !important;
			/*text-white*/
			box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
			/*shadow*/
			font-weight: 700;
			/*font-bold*/
			border-radius: .25rem;
			/*rounded*/
			background: #667eea !important;
			/*bg-indigo-500*/
			border: 1px solid transparent;
			/*border border-transparent*/
		}

		/*Pagination Buttons - Hover */
		.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
			color: #fff !important;
			/*text-white*/
			box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
			/*shadow*/
			font-weight: 700;
			/*font-bold*/
			border-radius: .25rem;
			/*rounded*/
			background: #667eea !important;
			/*bg-indigo-500*/
			border: 1px solid transparent;
			/*border border-transparent*/
		}

		/*Add padding to bottom border */
		table.dataTable.no-footer {
			border-bottom: 1px solid #e2e8f0;
			/*border-b-1 border-gray-300*/
			margin-top: 0.75em;
			margin-bottom: 0.75em;
		}

		/*Change colour of responsive icon*/
		table.dataTable.dtr-inline.collapsed>tbody>tr>td:first-child:before,
		table.dataTable.dtr-inline.collapsed>tbody>tr>th:first-child:before {
			background-color: #667eea !important;
			/*bg-indigo-500*/
		}
	</style>



</head>

<body class="bg-gray-100 text-gray-900 tracking-wider leading-normal">


	<!--Container-->
	<div class="container w-full md:w-4/5 xl:w-3/5  mx-auto px-2">

		<!--Title-->
		<h1 class="flex items-center font-sans font-bold break-normal text-indigo-500 px-2 py-8 text-xl md:text-2xl">
			Responsive <a class="underline mx-2" href="https://datatables.net/">DataTables.net</a> Table
		</h1>


		<!--Card-->
		<div id='recipients' class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">


			<table id="productTable" class="stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
				<thead class="bg-blue-500">
					<tr>
						<th data-priority="1" class="text-white">Name</th>
						<th data-priority="2" class="text-white">Price</th>
						<th data-priority="3" class="text-white">Link</th>
						<th data-priority="4" class="text-white">deskripsi</th>
						<th data-priority="5" class="text-white">Image</th>
						<th data-priority="6" class="text-white">Action</th>
					</tr>
				</thead>
				<tbody>
                    @foreach($products as $product)
					<tr>
						<td>{{$product->nama}}</td>
						<td>{{$product->harga}}</td>
						<td>{{$product->link}}</td>
						<td>{{$product->deskripsi}}</td>
						 <td><a href="#" onclick="openModal('{{ asset('storage/' . $product->image) }}')"><img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->nama }}" title="{{ $product->nama }}" width="100"></a></td>
						<td>
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
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

	<!-- Modal -->
	<div id="imageModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center hidden">
	    <div class="bg-white p-4 rounded-lg">
	        <img id="modalImage" src="" alt="Image" class="max-w-full h-auto">
	        <button onclick="closeModal()" class="mt-4 px-4 py-2 bg-red-500 text-white rounded-lg">Close</button>
	    </div>
	</div>

	<!-- jQuery -->
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

	<!--Datatables -->
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
	<script>
		$(document).ready(function() {
			var table = $('#productTable').DataTable({
					responsive: true
				})
				.columns.adjust()
				.responsive.recalc();
			
			// Add margin-bottom to show entries and search elements
			$('.dataTables_length').addClass('mb-4');
			$('.dataTables_filter').addClass('mb-4');
		});

		function openModal(imageSrc) {
		    document.getElementById('modalImage').src = imageSrc;
		    document.getElementById('imageModal').classList.remove('hidden');
		}

		function closeModal() {
		    document.getElementById('imageModal').classList.add('hidden');
		}
	</script>

</body>

</html>