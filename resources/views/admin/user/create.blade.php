@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Create New Users</h1>
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        @for ($i = 0; $i < request()->get('count', 1); $i++)
        <div class="mb-4">
            <label for="name_{{ $i }}" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" name="users[{{ $i }}][name]" id="name_{{ $i }}" class="mt-1 block w-full" required>
        </div>
        <div class="mb-4">
            <label for="email_{{ $i }}" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="users[{{ $i }}][email]" id="email_{{ $i }}" class="mt-1 block w-full" required>
        </div>
        <div class="mb-4">
            <label for="password_{{ $i }}" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="users[{{ $i }}][password]" id="password_{{ $i }}" class="mt-1 block w-full" required>
        </div>
        <div class="mb-4">
            <label for="password_confirmation_{{ $i }}" class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <input type="password" name="users[{{ $i }}][password_confirmation]" id="password_confirmation_{{ $i }}" class="mt-1 block w-full" required>
        </div>
        <div class="mb-4">
            <label for="usertype_{{ $i }}" class="block text-sm font-medium text-gray-700">User Type</label>
            <select name="users[{{ $i }}][usertype]" id="usertype_{{ $i }}" class="mt-1 block w-full" required>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="max_orders_per_day_{{ $i }}" class="block text-sm font-medium text-gray-700">Max Orders Per Day</label>
            <input type="number" name="users[{{ $i }}][max_orders_per_day]" id="max_orders_per_day_{{ $i }}" class="mt-1 block w-full" required>
        </div>
        @endfor
        <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Create</button>
        </div>
    </form>
</div>
@endsection
