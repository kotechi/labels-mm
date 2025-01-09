@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Content Management</h1>

    <!-- Chart Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        {!! $chart->html() !!}
    </div>

    <!-- About Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-700">About</h2>
            <a href="{{ route('abouts.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                <span class="mr-2">+</span> Create New About
            </a>
        </div>
        <div class="overflow-x-auto">
            <table id="aboutTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-blue-500">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($abouts as $about)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $about->tittle }}</td>
                        <td class="px-6 py-4">
                            <div class="line-clamp-2">{{ $about->description }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <a href="#" onclick="openModal('{{ asset('storage/' . $about->image) }}')">
                                <img src="{{ asset('storage/' . $about->image) }}" alt="{{ $about->tittle }}" title="{{ $about->tittle }}" class="h-20 w-20 object-cover rounded-lg">
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('abouts.edit', $about->id) }}" class="px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md">Edit</a>
                            <form action="{{ route('abouts.destroy', $about->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-md">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-700">Contact</h2>
            <a href="{{ route('contacts.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                <span class="mr-2">+</span> Create New Contact
            </a>
        </div>
        <div class="overflow-x-auto">
            <table id="contactTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-blue-500">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Link</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($contacts as $contact)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $contact->tittle }}</td>
                        <td class="px-6 py-4">{{ $contact->link }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('contacts.edit', $contact->id) }}" class="px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md">Edit</a>
                            <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-md">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-700">Header</h2>
            <a href="{{ route('headers.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                <span class="mr-2">+</span> Create New Header
            </a>
        </div>
        <div class="overflow-x-auto">
            <table id="headerTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-blue-500">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($headers as $header)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $header->tittle }}</td>
                        <td class="px-6 py-4">
                            <div class="line-clamp-2">{{ $header->description }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <a href="#" onclick="openModal('{{ asset('storage/' . $header->image) }}')">
                                <img src="{{ asset('storage/' . $header->image) }}" alt="{{ $header->tittle }}" title="{{ $header->tittle }}" class="h-20 w-20 object-cover rounded-lg">
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('headers.edit', $header->id) }}" class="px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md">Edit</a>
                            <form action="{{ route('headers.destroy', $header->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-md">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="imageModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center hidden">
    <div class="bg-white p-4 rounded-lg">
        <img id="modalImage" src="" alt="Image" class="max-w-full h-auto">
        <button onclick="closeModal()" class="mt-4 px-4 py-2 bg-red-500 text-white rounded-lg">Close</button>
    </div>
</div>

<!-- jQuery -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<!-- Datatables -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script>
    $(document).ready(function() {
        $('#aboutTable').DataTable({
            responsive: true
        }).columns.adjust().responsive.recalc();
        $('#contactTable').DataTable({
            responsive: true
        }).columns.adjust().responsive.recalc();
        $('#headerTable').DataTable({
            responsive: true
        }).columns.adjust().responsive.recalc();
        
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
{!! Charts::scripts() !!}
{!! $chart->script() !!}
@endsection