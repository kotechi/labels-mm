{{-- resources/views/admin/company/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Company Profile')

@section('content')

<div class="p-6 rounded-lg shadow bg-white">
    <div class="flex justify-between items-center">
        <h1 class="font-extrabold text-4xl" >Admin | Company Profile</h1>
    </div>
</div>

<!-- Header Section -->
<div class="mt-6 p-6 rounded-lg shadow-md bg-white">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold text-gray-700">Headers</h2>
        <a href="{{ route('headers.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            <span class="mr-2">+</span> Add New Header
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="datatable min-w-full divide-y divide-gray-200">
            <thead class="bg-thead">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Image</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($header as $head)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $head->tittle }}</td>
                    <td class="px-6 py-4 whitespace-normal max-w-xs truncate">{{ $head->description ?? 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if(isset($head->image))
                        <img src="{{ asset('storage/' . $head->image) }}" 
                             alt="{{ $head->tittle }}" 
                             class="h-16 w-16 object-cover rounded-lg">
                        @else
                        <span>No image</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('headers.edit', $head->id) }}" 
                           class="px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md">Edit</a>
                        <form action="{{ route('headers.destroy', $head->id) }}" 
                              method="POST" class="inline-block delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" 
                                    class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-md delete-button">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- About Section -->
<div class="mt-6 p-6 rounded-lg shadow-md bg-white">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold text-gray-700">About</h2>
        <a href="{{ route('abouts.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            <span class="mr-2">+</span> Add New About
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="datatable min-w-full divide-y divide-gray-200">
            <thead class="bg-thead">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Image</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($about as $item)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->tittle }}</td>
                    <td class="px-6 py-4 whitespace-normal max-w-xs truncate">{{ $item->deskripsi }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <img src="{{ asset('storage/' . $item->image) }}" 
                             alt="{{ $item->tittle }}" 
                             class="h-16 w-16 object-cover rounded-lg">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('abouts.edit', $item->id) }}" 
                           class="px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md">Edit</a>
                        <form action="{{ route('abouts.destroy', $item->id) }}" 
                              method="POST" class="inline-block delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" 
                                    class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-md delete-button">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


@endsection

@push('scripts')
<script>
    $(document).ready(function() {

        // SweetAlert for delete confirmation
        $('.delete-button').on('click', function() {
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush