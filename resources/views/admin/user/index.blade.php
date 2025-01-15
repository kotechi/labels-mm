@extends('layouts.admin')

@section('title', 'User Management')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">User Management</h1>
    <button id="createUserButton" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors mb-4">
        <span class="mr-2">+</span> Create New User
    </button>
    <div class="overflow-x-auto">
        <table id="userTable" class="min-w-full divide-y divide-gray-200">
            <thead class="bg-blue-500">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">Usertype</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">Max Oder</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($users as $user)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                    <td class="px-6 py-4">{{ $user->usertype }}</td>
                    <td class="px-6 py-4">{{ $user->max_orders_per_day }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('users.edit', $user->id) }}" class="px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md">Edit</a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline-block delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-md delete-button">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div id="createUserModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Create Users</h3>
                        <div class="mt-2">
                            <label for="numberOfUsers" class="block text-sm font-medium text-gray-700">Number of Users</label>
                            <input type="number" id="numberOfUsers" class="mt-1 block w-full" min="1" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button id="confirmCreateButton" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Create</button>
                <button id="cancelCreateButton" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Show modal
        document.getElementById('createUserButton').addEventListener('click', function() {
            document.getElementById('createUserModal').classList.remove('hidden');
        });

        // Hide modal
        document.getElementById('cancelCreateButton').addEventListener('click', function() {
            document.getElementById('createUserModal').classList.add('hidden');
        });

        // Handle create button
        document.getElementById('confirmCreateButton').addEventListener('click', function() {
            var numberOfUsers = document.getElementById('numberOfUsers').value;
            if (numberOfUsers > 0) {
                window.location.href = "{{ route('users.create') }}?count=" + numberOfUsers;
            }
        });
    });
</script>
@endsection
